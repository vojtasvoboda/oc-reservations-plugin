<?php

return [

    /**
     * Set up reservations.
     */
    'reservation' => [

        /**
         * Reservations interval slot. Used for reservation form time picker.
         */
        'interval' => 15,

        /**
         * Length of one reservation. How much time one reservation takes.
         * Note that when you have reservation at 09:00 with 2 hours lenght,
         * next possible reservation is at 11:00 and previous possible
         * reservation is at 07:00 to not cover reservation from 09:00!
         */
        'length' => '2 hours',
    ],

    /**
     * Reservation statuses config.
     */
    'statuses' => [

        /**
         * Reservation status ident assigned after create.
         */
        'received' => 'received',

        /**
         * Reservation status idents that doesn't blocks terms for booking.
         */
        'cancelled' => ['cancelled'],
    ],

    /**
     * Datetime formats.
     */
    'formats' => [

        'date' => 'd/m/Y',

        'time' => 'H:i',
    ],

    /**
     * Send reservation confirmation to you as blind carbon copy.
     */
    'mail' => [
        'bcc_email' => '',
        'bcc_name' => '',
    ],

    /**
     * Reservation random number. For disable, just set min to 0.
     */
    'number' => [
        'min' => 123456,
        'max' => 999999,
    ],

    /**
     * Reservation random hash. For disable set to 0.
     */
    'hash' => 32,

    /**
     * Minimum amount of time between two form submissions.
     *
     * @see http://carbon.nesbot.com/docs/ for syntax
     */
    'protection_time' => '-30 seconds',
];
