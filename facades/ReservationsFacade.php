<?php namespace VojtaSvoboda\Reservations\Facades;

use Auth;
use Carbon\Carbon;
use Config;
use Event;
use Illuminate\Database\Eloquent\Collection;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use VojtaSvoboda\Reservations\Classes\DatesResolver;
use VojtaSvoboda\Reservations\Mailers\ReservationMailer;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Status;

/**
 * Main reservations facade. Public interface.
 *
 * Usage: App::make('reservations');
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

    /**
     * ReservationsFacade constructor.
     *
     * @param Reservation $reservations
     * @param Status $statuses
     * @param DatesResolver $resolver
     */
    public function __construct(Reservation $reservations, Status $statuses, DatesResolver $resolver)
    {
        $this->reservations = $reservations;
        $this->statuses = $statuses;
        $this->datesResolver = $resolver;
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

        // send reservation confirmation
        ReservationMailer::send($reservation);

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
     * Get all reserved dates and times, according to reservation length.
     *
     * @return array
     */
    public function getReservedDates()
    {
        $reservations = $this->reservations->notCancelled()->get();

        return $this->datesResolver->getDatesFromReservations($reservations);
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
