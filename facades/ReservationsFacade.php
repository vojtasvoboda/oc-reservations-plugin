<?php namespace VojtaSvoboda\Reservations\Facades;

use Auth;
use Carbon\Carbon;
use Config;
use Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use VojtaSvoboda\Reservations\Classes\DatesResolver;
use VojtaSvoboda\Reservations\Mailers\ReservationAdminMailer;
use VojtaSvoboda\Reservations\Mailers\ReservationMailer;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Settings;
use VojtaSvoboda\Reservations\Models\Status;

/**
 * Public reservations facade.
 *
 * Usage: App::make('vojtasvoboda.reservations.facade');
 *
 * @package VojtaSvoboda\Reservations\Facades
 */
class ReservationsFacade
{
    /** @var Reservation $reservations */
    private $reservations;

    /** @var Status $statuses */
    private $statuses;

    /** @var DatesResolver $datesResolver */
    private $datesResolver;

    /** @var array $returningUsersCache */
    private $returningUsersCache;

    /** @var ReservationMailer $mailer */
    private $mailer;

    /** @var ReservationAdminMailer $adminMailer */
    private $adminMailer;

    /**
     * ReservationsFacade constructor.
     *
     * @param Reservation $reservations
     * @param Status $statuses
     * @param DatesResolver $resolver
     * @param ReservationMailer $mailer
     * @param ReservationAdminMailer $adminMailer
     */
    public function __construct(
        Reservation $reservations, Status $statuses, DatesResolver $resolver,
        ReservationMailer $mailer, ReservationAdminMailer $adminMailer
    ) {
        $this->reservations = $reservations;
        $this->statuses = $statuses;
        $this->datesResolver = $resolver;
        $this->mailer = $mailer;
        $this->adminMailer = $adminMailer;
    }

    /**
     * Create and store reservation.
     *
     * @param array $data
     *
     * @return Reservation $reservation
     *
     * @throws ApplicationException
     * @throws ValidationException
     */
    public function storeReservation($data)
    {
        // transform date and time to Carbon
        $data['date'] = $this->transformDateTime($data);

        // check date availability
        $this->checkDate($data);

        // create reservation
        $reservation = $this->reservations->create($data);

        // calculate reservations by same email
        $sameCount = $this->getReservationsWithSameEmailCount($reservation->email);

        // send reservation confirmation to customer
        $this->mailer->send($reservation, $sameCount);

        // send reservation confirmation to admin
        $this->adminMailer->send($reservation, $sameCount);

        return $reservation;
    }

    /**
     * Get all reservations.
     *
     * @return Collection
     */
    public function getReservations()
    {
        return $this->reservations->all();
    }

    /**
     * Get all active (not cancelled) reservations.
     *
     * @return Collection
     */
    public function getActiveReservations()
    {
        return $this->reservations->notCancelled()->get();
    }

    /**
     * Get all reserved time slots.
     *
     * @return array
     */
    public function getReservedDates()
    {
        $reservations = $this->getActiveReservations();

        return $this->datesResolver->getDatesFromReservations($reservations);
    }

    /**
     * Get all reservations by given date interval.
     *
     * @param Carbon $since Date from.
     * @param Carbon $till Date to.
     *
     * @return mixed
     */
    public function getReservationsByInterval(Carbon $since, Carbon $till)
    {
        return $this->reservations->whereBetween('date', [$since, $till])->get();
    }

    /**
     * Get reservations count by one email.
     *
     * @param $email
     *
     * @return int
     */
    public function getReservationsWithSameEmailCount($email)
    {
        return $this->reservations->where('email', $email)->notCancelled()->count();
    }

    /**
     * Is user returning or not? You have to set this parameter at Backend Reservations setting.
     *
     * @param $email
     *
     * @return bool
     */
    public function isUserReturning($email)
    {
        // if disabled, return always false
        $threshold = Settings::get('returning_mark', 0);
        if ($threshold < 1) {
            return false;
        }

        // load emails count
        if ($this->returningUsersCache === null) {
            $items = $this
                ->reservations
                ->select(DB::raw('email, count(*) as count'))
                ->groupBy('email')
                ->get();
            // refactor to mapWithKeys after upgrade to Laravel 5.3.
            foreach($items as $item) {
                $this->returningUsersCache[$item['email']] = $item['count'];
            }
        }

        $returning = $this->returningUsersCache;
        $actual = isset($returning[$email]) ? $returning[$email] : 0;

        return $threshold > 0 && $actual >= $threshold;
    }

    /**
     * Bulk reservation state change.
     *
     * @param array $ids
     * @param string $ident
     */
    public function bulkStateChange($ids, $ident)
    {
        // get state
        $status = $this->statuses->where('ident', $ident)->first();
        if (!$status) {
            return;
        }

        // go through reservations
        foreach ($ids as $id)
        {
            $reservation = $this->reservations->find($id);
            if (!$reservation) {
                continue;
            }

            $reservation->status = $status;
            $reservation->save();
        }
    }

    /**
     * Bulk reservations delete.
     *
     * @param array $ids
     */
    public function bulkDelete($ids)
    {
        // go through reservations
        foreach ($ids as $id)
        {
            $reservation = $this->reservations->find($id);
            if (!$reservation) {
                continue;
            }

            $reservation->delete();
        }
    }

    /**
     * Transform date and time to DateTime string.
     *
     * @param $data
     *
     * @return Carbon
     *
     * @throws ApplicationException
     */
    public function transformDateTime($data)
    {
        // validate date and time
        if (empty($data['date'])) {
            throw new ApplicationException('You have to select pickup date!');

        } elseif (empty($data['time'])) {
            throw new ApplicationException('You have to select pickup hour!');
        }

        $format = Config::get('vojtasvoboda.reservations::config.formats.datetime', 'd/m/Y H:i');

        return Carbon::createFromFormat($format, trim($data['date'] . ' ' . $data['time']));
    }

    /**
     * Check gived date and time.
     *
     * @param array $data
     *
     * @throws ApplicationException
     */
    public function checkDate($data)
    {
        // check reservation sent limit
        if ($this->isSomeReservationExistsInLastTime()) {
            throw new ApplicationException('You can sent only one reservation per 30 seconds, please wait a second.');
        }

        // check date availability
        if (!$this->isDateAvailable($data['date'])) {
            throw new ApplicationException($data['date']->format('d.m.Y H:i') . ' is already booked.');
        }
    }

    /**
     * Returns if date is available to book.
     *
     * @param Carbon $date
     *
     * @return bool
     */
    public function isDateAvailable(Carbon $date)
    {
        // get config
        $length = Config::get('vojtasvoboda.reservations::config.reservation.length', '2 hours');

        // check time slot before
        $startDatetime = clone $date;
        $startDatetime->modify('-' . $length);
        $startDatetime->modify('+1 second');

        // check time slot after
        $endDatetime = clone $date;
        $endDatetime->modify('+' . $length);
        $endDatetime->modify('-1 second');

        // get all reservations in this date
        $reservations = $this->reservations->notCancelled()->whereBetween('date', [$startDatetime, $endDatetime])->get();

        return $reservations->count() == 0;
    }

    /**
     * Try to find some reservation in less then half minute.
     *
     * @return boolean
     */
    public function isSomeReservationExistsInLastTime()
    {
        return $this->reservations->isExistInLastTime();
    }
}
