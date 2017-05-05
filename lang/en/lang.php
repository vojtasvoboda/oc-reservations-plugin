<?php

return [

    'plugin' => [
        'name' => 'Reservations',
        'description' => 'Quick reservations plugin.',
        'menu_label' => 'Reservations',
    ],

    'permission' => [
        'tab_label' => 'Reservations',
        'reservations' => 'Reservations management',
        'statuses' => 'Statuses management',
        'export' => 'Reservations export',
    ],

    'reservations' => [
        'menu_label' => 'Reservations',
        'widget_label' => 'Reservations',
        'bulk_actions' => 'Bulk actions',
        'approved' => 'Approve',
        'approved_question' => 'Are you sure to switch reservations as Approved?',
        'closed' => 'Close',
        'closed_question' => 'Are you sure to switch reservations as Closed?',
        'received' => 'Received',
        'received_question' => 'Are you sure to switch reservations as Received?',
        'cancelled' => 'Cancell',
        'cancelled_question' => 'Are you sure to switch reservations as Cancelled?',
        'delete' => 'Delete',
        'delete_question' => 'Are you sure to delete selected reservations?',
        'change_status_success' => 'Reservation states has been successfully changed.',
    ],

    'reservation' => [
        'date' => 'Date',
        'date_format' => 'd.m.Y H:i:s',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'status' => 'Status',
        'created_at' => 'Created at',
        'created_at_format' => 'd.m.Y H:i:s',
        'street' => 'Address / street',
        'message' => 'Message',
        'number' => 'Number',
        'returning' => 'Returning',
    ],

    'statuses' => [
        'menu_label' => 'Statuses',
        'change_order' => 'Change order',
    ],

    'status' => [
        'name' => 'Status',
        'color' => 'Color',
        'ident' => 'Ident',
        'order' => 'Sort order',
        'enabled' => 'Enabled',
        'created' => 'Created',
        'created_format' => 'd.m.Y H:i:s',
        'updated' => 'Updated',
        'updated_format' => 'd.m.Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Export',
        'status_filter' => 'Filter by status',
        'status_filter_label' => 'Status',
        'status_filter_tab' => 'Status',
    ],

    'reservationform' => [
        'name' => 'Reservation form',
        'description' => 'Form for taking reservations in specific date/time.',
        'success' => 'Reservation has been successfully sent!',
    ],

    'mail' => [
        'cs_label' => 'Reservation confirmation CS',
        'en_label' => 'Reservation confirmation EN',
        'es_label' => 'Reservation confirmation ES',
        'ru_label' => 'Reservation confirmation RU',
    ],
];
