<?php

return [

    /**
     * Set reservations.
     */
    'reservation' => [

        /**
         * Interval between two reservations.
         */
        'interval' => 15,

        /**
         * Length of one reservation.
         */
        'length' => '2 hours',
    ],

    /**
     * Reservation statuses config.
     */
    'statuses' => [

        /**
         * Reservation status after create.
         */
        'received' => 'received',

        /**
         * List of cancelled reservation statuses that doesn't blocks terms for booking.
         */
        'cancelled' => ['cancelled'],
    ],

    /**
     * Datetime formats.
     */
    'formats' => [

        'datetime' => 'd/m/Y H:i',

        'date' => 'd/m/Y',

        'time' => 'H:i',
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
];
