<?php namespace VojtaSvoboda\Reservations\Classes;

use Carbon\Carbon;
use Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DatesResolver transform reservations to booked time slots, grouped by date.
 *
 * @package VojtaSvoboda\Reservations\Classes
 */
class DatesResolver
{
    /**
     * Returns dates from reservations.
     *
     * @param Collection $reservations
     *
     * @return array
     */
    public function getDatesFromReservations(Collection $reservations)
    {
        // init
        $interval = $this->getInterval();
        $length = $this->getLength();

        // sort reservations by date and count time slots before reservation and during the reservation
        $dates = [];
        foreach ($reservations as $reservation)
        {
            /** @var Carbon $date */
            $date = Carbon::parse($reservation->date);
            $reservationDay = $date->format('d/m/Y');

            // reservation end date
            $endTime = clone $date;
            $endTime->modify('+' . $length);

            // each reservation takes some time
            $date->modify('-' . $length);
            $date->modify('+' . $interval . ' minutes');
            while ($date < $endTime) {
                $time = $date->format('H:i');
                $dates[$reservationDay][$time] = $time;
                $date->modify('+' . $interval . ' minutes');
            }
        }

        return $dates;
    }

    private function getInterval()
    {
        return Config::get('vojtasvoboda.reservations::config.reservation.interval', 15);
    }

    private function getLength()
    {
        return Config::get('vojtasvoboda.reservations::config.reservation.length', '2 hours');
    }
}
