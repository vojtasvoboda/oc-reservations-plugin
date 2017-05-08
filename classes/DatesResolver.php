<?php namespace VojtaSvoboda\Reservations\Classes;

use Carbon\Carbon;
use Config;
use Illuminate\Database\Eloquent\Collection;
use VojtaSvoboda\Reservations\Models\Settings;

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
        $dateFormat = 'd/m/Y';
        $timeFormat = 'H:i';

        // sort reservations by date and count time slots before reservation and during the reservation
        $dates = [];
        foreach ($reservations as $reservation) {
            // init dates
            $startDate = $this->getStartDate($reservation, $length, $interval);
            $endDate = $this->getEndDate($reservation, $length);

            // save each booked interval
            while ($startDate < $endDate) {
                $time = $startDate->format($timeFormat);
                $dates[$startDate->format($dateFormat)][$time] = $time;
                $startDate->modify('+' . $interval . ' minutes');
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
    public function getBoundaryDates(Carbon $date)
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
     * @param Carbon $date
     * @param string $length
     *
     * @return mixed
     */
    private function getBoundaryBefore(Carbon $date, $length)
    {
        $startDatetime = clone $date;
        $startDatetime->modify('-' . $length);
        $startDatetime->modify('+1 second');

        return $startDatetime;
    }

    /**
     * Get boundary date after reservation date.
     *
     * @param Carbon $date
     * @param string $length
     *
     * @return mixed
     */
    private function getBoundaryAfter(Carbon $date, $length)
    {
        $endDatetime = clone $date;
        $endDatetime->modify('+' . $length);
        $endDatetime->modify('-1 second');

        return $endDatetime;
    }

    /**
     * Get reservation imaginary start date.
     *
     * @param $reservation
     * @param $length
     * @param $interval
     *
     * @return mixed
     */
    protected function getStartDate($reservation, $length, $interval)
    {
        $startDate = $reservation->date;
        $startDate->modify('-' . $length);
        $startDate->modify('+' . $interval . ' minutes');

        return $startDate;
    }

    /**
     * Get reservation imaginary end date.
     *
     * @param $reservation
     * @param $length
     *
     * @return mixed
     */
    protected function getEndDate($reservation, $length)
    {
        $endDate = clone $reservation->date;
        $endDate->modify('+' . $length);

        return $endDate;
    }

    protected function getDateFormat()
    {
        return Settings::get(
            'formats_date',
            Config::get('vojtasvoboda.reservations::config.formats.date', 'd/m/Y')
        );
    }

    protected function getTimeFormat()
    {
        return Settings::get(
            'formats_time',
            Config::get('vojtasvoboda.reservations::config.formats.time', 'H:i')
        );
    }

    protected function getInterval()
    {
        return Settings::get(
            'reservation_interval',
            Config::get('vojtasvoboda.reservations::config.reservation.interval', 15)
        );
    }

    protected function getLength()
    {
        return Settings::get(
            'reservation_length',
            (int)Config::get('vojtasvoboda.reservations::config.reservation.length', 2)
        ).' hours';
    }
}
