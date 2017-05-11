<?php namespace VojtaSvoboda\Reservations\Classes;

use Config;
use VojtaSvoboda\Reservations\Models\Settings;

class Variables
{
    public static function getDateTimeFormat()
    {
        $default = Config::get('vojtasvoboda.reservations::config.formats.datetime', 'd/m/Y H:i');

        return Settings::get('formats_datetime', $default);
    }

    public static function getDateFormat()
    {
        $default = Config::get('vojtasvoboda.reservations::config.formats.date', 'd/m/Y');

        return Settings::get('formats_date', $default);
    }

    public static function getTimeFormat()
    {
        $default = Config::get('vojtasvoboda.reservations::config.formats.time', 'H:i');

        return Settings::get('formats_time', $default);
    }

    public static function getReservationInterval()
    {
        $default = Config::get('vojtasvoboda.reservations::config.reservation.interval', 15);

        return (int) Settings::get('reservation_interval', $default);
    }

    public static function getReservationLength()
    {
        $default = (int) Config::get('vojtasvoboda.reservations::config.reservation.length', 2);

        return Settings::get('reservation_length', $default) . ' hours';
    }

    public static function getWorkingDays()
    {
        $default = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

        return Settings::get('work_days', $default);
    }

    public static function getFirstWeekday()
    {
        return (int) Settings::get('first_weekday', false);
    }

    public static function getWorkTimeFrom()
    {
        return Settings::get('work_time_from', '10:00');
    }

    public static function getWorkTimeTo()
    {
        return Settings::get('work_time_to', '18:00');
    }
}
