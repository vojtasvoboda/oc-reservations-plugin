<?php

return [

    'plugin' => [
        'name' => 'Reservations',
        'category' => 'Rezervace',
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
        'time' => 'Time',
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
        'submit' => 'Submit',
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

    'errors' => [
        'empty_date' => 'You have to select pickup date!',
        'empty_hour' => 'You have to select pickup hour!',
        'please_wait' => 'You can sent only one reservation per 30 seconds, please wait a second.',
        'session_expired' => 'Form session expired! Please refresh the page.',
        'exception' => 'We\'re sorry, but something went wrong and the form cannot be sent.',
        'already_booked' => 'Date :reservation is already booked.',
    ],

    'settings' => [
        'description' => 'Manage Reservations settings.',
        'tabs' => [
            'plugin'  => 'Reservations settings',
            'admin'   => 'Admin confirmation',
        ],

        'returning_mark' => [
            'label'   => 'Mark returning customers',
            'comment' => 'Mark customers with that number of reservations or more. Disable by value 0.',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Enable admin confirmation',
        ],
        'admin_confirmation_email' => [
            'label'   => 'Admin email',
            'comment' => 'Admin email for sending confirmation.',
        ],
        'admin_confirmation_name' => [
            'label'   => 'Admin name',
            'comment' => 'Admin name for confirmation email.',
        ],
        'admin_confirmation_locale' => [
            'label'   => 'Admin confirmation locale',
            'comment' => 'Locale of confirmation email.',
        ],
    ],
];
