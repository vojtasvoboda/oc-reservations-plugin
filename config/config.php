<?php

return [

    'reservation' => [

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
         * Reservation random number. For disable generating this number, just
         * set min to 0.
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
         * Reservation statuses config.
         */
        'statuses' => [

            /**
             * Reservation status after create.
             */
            'received' => 'received',

            /**
             * List of invalid reservation statuses - this reservations doesn't
             * block terms for booking.
             */
            'invalid' => ['cancelled'],
        ]
    ],
];
