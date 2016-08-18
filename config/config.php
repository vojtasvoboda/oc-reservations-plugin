<?php

return [

    /**
     * Set reservation times.
     */
    'time' => [

        /**
         * Interval between two dates.
         */
        'interval' => 15,

        /**
         * Capacity of one date.
         */
        'capacity' => 1,
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
     * Reservation random number. For disable, just set min to 0.
     */
    'number' => [
        'min' => 123456,
        'max' => 999999,
    ],

    /**
     * Reservation random hash. For disable set to 0.
     */
    'hash' => [
        'length' => 32
    ],
];
