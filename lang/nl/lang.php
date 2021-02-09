<?php

return [

    'plugin' => [
        'name' => 'Reserveringen',
        'category' => 'Reserveringen',
        'description' => 'Snelle reservering plugin.',
        'menu_label' => 'Reserveringen',
    ],

    'permission' => [
        'tab_label' => 'Reserveringen',
        'reservations' => 'Reservering management',
        'statuses' => 'Status management',
        'export' => 'Reserveringen exporteren',
    ],

    'reservations' => [
        'menu_label' => 'Reserveringen',
        'widget_label' => 'Reserveringen',
        'bulk_actions' => 'Bulk acties',
        'approved' => 'Goedkeuren',
        'approved_question' => 'Weet u zeker dat deze reservering is Goedgekeurd?',
        'closed' => 'Sluiten',
        'closed_question' => 'Weet u zeker dat u deze reservering wilt sluiten?',
        'received' => 'Ontvangen',
        'received_question' => 'Weet u zeker dat u deze reservering naar Ontvangen wilt zetten?',
        'cancelled' => 'Annuleren',
        'cancelled_question' => 'Weet u zeker dat u deze reservering op Annuleren wilt zetten?',
        'delete' => 'Verwijderen',
        'delete_question' => 'Weet u zeker dat u de geselecteerde reserveringen wilt verwijderen?',
        'change_status_success' => 'Reservering status succesvol gewijzigd.',
    ],

    'reservation' => [
        'date' => 'Datum',
        'time' => 'Tijd',
        'date_format' => 'd.m.Y H:i:s',
        'name' => 'Naam',
        'email' => 'Email',
        'phone' => 'Telefoon',
        'status' => 'Status',
        'created_at' => 'Gemaakt op',
        'created_at_format' => 'd.m.Y H:i:s',
        'street' => 'Adres / straat',
        'message' => 'Bericht',
        'number' => 'Nummer',
        'returning' => 'Terugkomst',
        'submit' => 'Verzenden',
    ],

    'statuses' => [
        'menu_label' => 'Status',
        'change_order' => 'Verander volgorde',
    ],

    'status' => [
        'name' => 'Status',
        'color' => 'Kleur',
        'ident' => 'Ident',
        'order' => 'Sorteer',
        'enabled' => 'Ingeschakeld',
        'created' => 'Gemaakt',
        'created_format' => 'd.m.Y H:i:s',
        'updated' => 'Aangepast',
        'updated_format' => 'd.m.Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Export',
        'status_filter' => 'Filter op status',
        'status_filter_label' => 'Status',
        'status_filter_tab' => 'Status',
    ],

    'reservationform' => [
        'name' => 'Reserverings formolier',
        'description' => 'Formulier om reserveringen op te nemen.',
        'success' => 'Reservering is verzonden!',
    ],

    'mail' => [
        'cs_label' => 'Reservering confirmatie CS',
        'en_label' => 'Reservering confirmatie EN',
        'es_label' => 'Reservering confirmatie ES',
        'fr_label' => 'Reservering confirmatie FR',
        'ru_label' => 'Reservering confirmatie RU',
    ],

    'errors' => [
        'empty_date' => 'Vul een datum in!',
        'empty_hour' => 'Vul een tijd in!',
        'please_wait' => 'U kunt één reservering per 30 seconden verzenden, even geduld a.u.b.',
        'session_expired' => 'Formulier sessie verlopen! Ververs de paga a.u.b.',
        'exception' => 'Onze excuses, maar er ging iets mis en het formulier kon niet worden verzonden.',
        'already_booked' => 'Datum :reservering is al geboekt.',
        'days_off' => 'Geselecteerde datum is niet correct.',
        'out_of_hours' => 'Selecteerde tijd is buiten onze uren.',
        'past_date' => 'Selecteerde datum is al voorbij.',
    ],

    'settings' => [
        'description' => 'Reserverings instellingen aanpassen.',
        'tabs' => [
            'plugin'  => 'Reserverings instellingen',
            'admin'   => 'Admin confirmatie',
            'datetime' => 'Datum, tijd instellingen',
            'returning' => 'Terugkerende klanten',
            'working_days' => 'Werkdagen',
        ],

        'returning_mark' => [
            'label'   => 'Terugkerende klanten markeren',
            'comment' => 'Markeer klanten met dit aantal reserveringen of meer. Uitzetten met waarde 0.',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Admin confirmatie aanzetten',
        ],
        'admin_confirmation_email' => [
            'label'   => 'Admin email',
            'comment' => 'Admin email voor confirmatie verzending.',
        ],
        'admin_confirmation_name' => [
            'label'   => 'Admin naam',
            'comment' => 'Admin naam voor confirmatie email.',
        ],
        'admin_confirmation_locale' => [
            'label'   => 'Admin confirmatie locale',
            'comment' => 'Locale van confirmatie email.',
        ],
        'reservation_interval' => [
            'label'   => 'Reservering interval (minuten)',
            'comment' => 'Voor reserverings formulier tijd selectie.',
        ],
        'reservation_length' => [
            'label'   => 'Lengte van een reservering',
            'comment' => 'Hoe lang een reservering duurt.',
        ],
        'reservation_length_unit' => [
            'options' => [
                'minutes' => 'minuten',
                'hours' => 'uren',
                'days' => 'dagen',
                'weeks' => 'weken',
            ],
        ],
        'formats_date' => [
            'label'   => 'Datum formaat',
            'comment' => 'Opties: d, dd, ddd, dddd, m, mm, mmm, mmmm, yy, yyyy, Y',
        ],
        'formats_time' => [
            'label'   => 'Tijd formaat',
            'comment' => 'Opties: h, hh, H, HH, i, a, A',
        ],
        'first_weekday' => [
            'label'   => 'Eerste dag van de week is Maandag?',
        ],
        'work_time_from' => [
            'label'   => 'Start werken vanaf',
            'comment' => 'Tijd om in te voeren HH:mm (24 uurs formaat)',
        ],
        'work_time_to' => [
            'label'   => 'Stop werken om',
            'comment' => 'Tijd om in te voeren HH:mm (24 uurs formaat)',
        ],
        'work_days' => [
            'label'   => 'Werk dagen',
            'monday'    => 'Maandag',
            'tuesday'   => 'Dinsdag',
            'wednesday' => 'Woensdag',
            'thursday'  => 'Donderdag',
            'friday'    => 'Vrijdag',
            'saturday'  => 'Zaterdag',
            'sunday'    => 'Zondag',
        ],
    ],
];
