<?php namespace VojtaSvoboda\Reservations\Facades;

use Auth;
use Carbon\Carbon;
use Config;
use Event;
use Illuminate\Database\Eloquent\Collection;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
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

    /**
     * ReservationsFacade constructor.
     *
     * @param Reservation $reservations
     * @param Status $statuses
     */
    public function __construct(Reservation $reservations, Status $statuses)
    {
        $this->reservations = $reservations;
        $this->statuses = $statuses;
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
        // check date availability
        $this->checkDate($data);

        // add default status
        $data['status'] = $this->getDefaultState();

        // date and time together
        if (!empty($data['date'])) {
            $date = Carbon::createFromFormat('d/m/Y H:i', $data['date'] . ' ' . $data['time']);
            $data['date'] = $date->toDateTimeString();
        }

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
     * Get all reserved dates, according to reservation length.
     */
    public function getReservedDates()
    {

    }

    /**
     * Get default reservation state.
     *
     * @return Status
     */
    private function getDefaultState()
    {
        $statusIdent = Config::get('vojtasvoboda.reservations::config.statuses.received', 'received');

        return $this->statuses->where('ident', $statusIdent)->first();
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
     * Check gived date and time.
     *
     * @param array $data
     *
     * @throws ApplicationException
     */
    private function checkDate($data)
    {
        // validate date
        if (empty($data['date'])) {
            throw new ApplicationException('You have to select pickup date!');
        }

        // validate time
        if (!empty($data['date']) && empty($data['time'])) {
            throw new ApplicationException('You have to select pickup hour!');
        }

        // check reservation sent limit
        if ($this->isSomeReservationExistsInLastTime()) {
            throw new ApplicationException('You can sent only one reservation per 30 seconds, please wait a second.');
        }

        // check date availability
        if (!$this->isDateAvailable($data['date'], $data['time'])) {
            throw new ApplicationException('This date and time is already booked.');
        }
    }

    public function isDateAvailable($date, $time)
    {
        return true;
    }

    /**
     * Try to find some reservation in less then half minute.
     *
     * @return boolean
     */
    private function isSomeReservationExistsInLastTime()
    {
        return $this->reservations->isExistInLastTime();
    }
}
