<?php

return [

    'plugin' => [
        'name' => 'Reservations',
        'category' => 'Reservations',
        'description' => 'Quick reservations plugin.',
        'menu_label' => 'Rezervari',
    ],

    'permission' => [
        'tab_label' => 'Reservations',
        'reservations' => 'Reservations management',
        'statuses' => 'Statuses management',
        'export' => 'Reservations export',
    ],

    'reservations' => [
        'menu_label' => 'Rezervari',
        'widget_label' => 'Rezervari',
        'bulk_actions' => 'Actiuni grup',
        'approved' => 'Aproba',
        'approved_question' => 'Doriti sa confirmati rezervarile (aprobare)?',
        'closed' => 'Inchide',
        'closed_question' => 'Doriti sa modificati rezervarile (inchidere)?',
        'received' => 'Primit',
        'received_question' => 'Doriti sa modificati rezervarile (primit)?',
        'cancelled' => 'Anulat',
        'cancelled_question' => 'Doriti sa modificati rezervarile (anulat)?',
        'delete' => 'Sterge',
        'delete_question' => 'Doriti sa modificati rezervarile (stergere)?',
        'change_status_success' => 'Rezervarile au fost modificate cu success.',
    ],

    'reservation' => [
        'date' => 'Data',
        'time' => 'Timp',
        'date_format' => 'd.m.Y H:i:s',
        'name' => 'Nume',
        'email' => 'Email',
        'phone' => 'Telefon',
        'status' => 'Status',
        'created_at' => 'Creat la',
        'created_at_format' => 'd.m.Y H:i:s',
        'street' => 'Adresa / strada',
        'message' => 'Mesaj',
        'number' => 'Numar',
        'returning' => 'Reintoarcere',
        'submit' => 'Trimite',
    ],

    'statuses' => [
        'menu_label' => 'Statusuri',
        'change_order' => 'Schimba oridinea',
    ],

    'status' => [
        'name' => 'Status',
        'color' => 'Culoare',
        'ident' => 'Identare',
        'order' => 'Ordine sortare',
        'enabled' => 'Activat',
        'created' => 'Creat',
        'created_format' => 'd.m.Y H:i:s',
        'updated' => 'Actualizat',
        'updated_format' => 'd.m.Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Export',
        'status_filter' => 'Filtreaza dupa status',
        'status_filter_label' => 'Status',
        'status_filter_tab' => 'Status',
    ],

    'reservationform' => [
        'name' => 'Formular rezervari',
        'description' => 'Formular pentru a rezerva in anumita data/timp.',
        'success' => 'Rezervarea a fost trimisa cu success!',
    ],

    'mail' => [
        'cs_label' => 'Reservation confirmation CS',
        'en_label' => 'Reservation confirmation EN',
        'es_label' => 'Reservation confirmation ES',
        'fr_label' => 'Reservation confirmation FR',
        'ru_label' => 'Reservation confirmation RU',
        'ro_label' => 'Reservation confirmation RO',
    ],

    'errors' => [
        'empty_date' => 'Va rugam sa selectati data!',
        'empty_hour' => 'Va rugam sa selectati ora!',
        'please_wait' => 'Puteti trimite o rezervare la 30 de secunde, putina rabdare stimabile!',
        'session_expired' => 'Sesiune expirata! Reincarcati pagina!',
        'exception' => 'Ne pare rau, formularul nu a putut fi trimis',
        'already_booked' => 'Data :reservation e ocupata.',
        'days_off' => 'Data aleasa nu e disponibila.',
        'out_of_hours' => 'Ora aleasa nu e disponibila.',
        'past_date' => 'Data aleasa e in trecut.',
    ],

    'settings' => [
        'description' => 'Gestionati setarile Rezervarilor.',
        'tabs' => [
            'plugin'  => 'Setari rezervar',
            'admin'   => 'Admin',
            'datetime' => 'Setari data, timp',
            'returning' => 'Clienti recurenti',
            'working_days' => 'Zile lucratoare',
        ],

        'returning_mark' => [
            'label'   => 'Marcheaza clienti recurenti',
            'comment' => 'Marcheaza clienti cu acel numar de rezervari sau mai mare. Dezactivat cu valoarea 0.',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Activeaza confirmarea administratorului',
        ],
        'admin_confirmation_email' => [
            'label'   => 'Email administrator',
            'comment' => 'Email administrator pentru trimiterea confirmari.',
        ],
        'admin_confirmation_name' => [
            'label'   => 'Nume admin',
            'comment' => 'Nume admin pentru email confirmare.',
        ],
        'admin_confirmation_locale' => [
            'label'   => 'Confirmare locala',
            'comment' => 'Email confirmare localizat/traducere.',
        ],
        'reservation_interval' => [
            'label'   => 'Slot rezervare (minute)',
            'comment' => 'Folosit pentru alegere rezervare calendar.',
        ],
        'reservation_length' => [
            'label'   => 'Durata rezervarii',
            'comment' => 'Cat timp dureaza rezervarea.',
        ],
        'reservation_length_unit' => [
            'options' => [
                'minutes' => 'minute',
                'hours' => 'ore',
                'days' => 'zile',
                'weeks' => 'saptamani',
            ],
        ],
        'formats_date' => [
            'label'   => 'Format data',
            'comment' => 'You can use: d, dd, ddd, dddd, m, mm, mmm, mmmm, yy, yyyy, Y',
        ],
        'formats_time' => [
            'label'   => 'Format timp',
            'comment' => 'You can use: h, hh, H, HH, i, a, A',
        ],
        'first_weekday' => [
            'label'   => 'Prima zi e Luni?',
        ],
        'work_time_from' => [
            'label'   => 'Start la',
            'comment' => 'Time to format HH:mm (24 hours format)',
        ],
        'work_time_to' => [
            'label'   => 'Terminare la?',
            'comment' => 'Time to format HH:mm (24 hours format)',
        ],
        'work_days' => [
            'label'   => 'Zile lucratoare',
            'monday'    => 'Luni',
            'tuesday'   => 'Marti',
            'wednesday' => 'Miercuri',
            'thursday'  => 'Joi',
            'friday'    => 'Vineri',
            'saturday'  => 'Sambata',
            'sunday'    => 'Duminica',
        ],
    ],
];
