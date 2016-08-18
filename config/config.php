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
         * Capacity of one reservation.
         */
        'capacity' => 1,

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
