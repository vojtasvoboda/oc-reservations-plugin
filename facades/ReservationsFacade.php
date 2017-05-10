<?php namespace VojtaSvoboda\Reservations\Facades;

use Auth;
use Carbon\Carbon;
use Config;
use Event;
use Lang;
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
 * Usage: App::make(ReservationsFacade::class);
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
        // check number of sends
        $this->checkLimits();

        // transform date and time to Carbon
        $data['date'] = $this->transformDateTime($data);

        // place for extending
        Event::fire('vojtasvoboda.reservations.processReservation', [&$data]);

        // create reservation
        $reservation = $this->reservations->create($data);

        // send mails to client and admin
        $this->sendMails($reservation);

        return $reservation;
    }

    /**
     * Send mail to client and admin.
     *
     * @param Reservation $reservation
     */
    public function sendMails($reservation)
    {
        // calculate reservations by same email
        $sameCount = $this->getReservationsCountByMail($reservation->email);

        // send reservation confirmation to customer
        $this->mailer->send($reservation, $sameCount);

        // send reservation confirmation to admin
        $this->adminMailer->send($reservation, $sameCount);
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
    public function getReservationsCountByMail($email)
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
        // when disabled, user is never returning
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
        // validate date
        if (empty($data['date'])) {
            throw new ApplicationException(Lang::get('vojtasvoboda.reservations::lang.errors.empty_date'));
        }

        // validate time
        if (empty($data['time'])) {
            throw new ApplicationException(Lang::get('vojtasvoboda.reservations::lang.errors.empty_hour'));
        }

        $format = Config::get('vojtasvoboda.reservations::config.formats.datetime', 'd/m/Y H:i');

        return Carbon::createFromFormat($format, trim($data['date'] . ' ' . $data['time']));
    }

    /**
     * Returns if given date is available.
     *
     * @param Carbon $date
     * @param int $exceptId Except reservation ID.
     *
     * @return bool
     */
    public function isDateAvailable($date, $exceptId = null)
    {
        // get boundary dates for given reservation date
        $boundaries = $this->datesResolver->getBoundaryDates($date);

        // get all reservations in this date
        $query = $this->reservations->notCancelled()->whereBetween('date', $boundaries);

        // if updating reservation, we should skip existing reservation
        if ($exceptId !== null) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->count() === 0;
    }

    /**
     * Check reservations amount limit per time.
     *
     * @throws ApplicationException
     */
    private function checkLimits()
    {
        if ($this->isCreatedWhileAgo()) {
            throw new ApplicationException(Lang::get('vojtasvoboda.reservations::lang.errors.please_wait'));
        }
    }

    /**
     * Try to find some reservation in less then given limit (default 30 seconds).
     *
     * @return boolean
     */
    public function isCreatedWhileAgo()
    {
        // protection time
        $time = Config::get('vojtasvoboda.reservations::config.protection_time', '-30 seconds');
        $timeLimit = Carbon::parse($time)->toDateTimeString();

        // try to find some message
        $item = $this->reservations->machine()->where('created_at', '>', $timeLimit)->first();

        return $item !== null;
    }
}
