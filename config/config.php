<?php

return [

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
