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
     * Returns reserved time slots from non cancelled reservations.
     *
     * If you have reservations at 13.10.2016 at 11:00 and also at 13:00, both with 2 hours lenght, this method return
     * all booked slots - from 09:15 to 14:45 (when you have 15 minutes slot lenght).
     *
     * ------------ 11:00 ------------- 13:00 --------------
     *
     * Because nearest reservation can be done at 09:00 with 2 hours lenghts and next reservation at 15:00.
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
        $dateFormat = $this->getDateFormat();
        $timeFormat = $this->getTimeFormat();

        // sort reservations by date and count time slots before reservation and during the reservation
        $dates = [];
        foreach ($reservations as $reservation)
        {
            /** @var Carbon $date */
            $date = Carbon::parse($reservation->date);
            $reservationDay = $date->format($dateFormat);

            // reservation end date
            $endTime = clone $date;
            $endTime->modify('+' . $length);

            // each reservation takes some time
            $date->modify('-' . $length);
            $date->modify('+' . $interval . ' minutes');
            while ($date < $endTime) {
                $time = $date->format($timeFormat);
                $dates[$reservationDay][$time] = $time;
                $date->modify('+' . $interval . ' minutes');
            }
        }

        return $dates;
    }

    /**
     * Get booked interval around the given date.
     *
     * @param Carbon $date
     *
     * @return array
     */
    public function getBoundaryDates($date)
    {
        // reservation length
        $length = $this->getLength();

        // boundary dates before and after
        $startDatetime = $this->getBoundaryBefore($date, $length);
        $endDatetime = $this->getBoundaryAfter($date, $length);

        return [$startDatetime, $endDatetime];
    }

    /**
     * Get boundary date before reservation date.
     *
     * @param $date
     * @param $length
     *
     * @return mixed
     */
    private function getBoundaryBefore($date, $length)
    {
        $startDatetime = clone $date;
        $startDatetime->modify('-' . $length);
        $startDatetime->modify('+1 second');

        return $startDatetime;
    }

    /**
     * Get boundary date after reservation date.
     *
     * @param $date
     * @param $length
     *
     * @return mixed
     */
    private function getBoundaryAfter($date, $length)
    {
        $endDatetime = clone $date;
        $endDatetime->modify('+' . $length);
        $endDatetime->modify('-1 second');

        return $endDatetime;
    }

    private function getDateFormat()
    {
        return Config::get('vojtasvoboda.reservations::config.formats.date', 'd/m/Y');
    }

    private function getTimeFormat()
    {
        return Config::get('vojtasvoboda.reservations::config.formats.time', 'H:i');
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
