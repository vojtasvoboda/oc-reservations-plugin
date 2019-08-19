<?php

return [

    'plugin' => [
        'name' => 'Rezervace',
        'category' => 'Rezervace',
        'description' => 'Plugin pro rychlé rezervace.',
        'menu_label' => 'Rezervace',
    ],

    'permission' => [
        'tab_label' => 'Rezervace',
        'reservations' => 'Správa rezervací',
        'statuses' => 'Správa statusů',
        'export' => 'Export rezervací',
    ],

    'reservations' => [
        'menu_label' => 'Rezervace',
        'widget_label' => 'Rezervace',
        'bulk_actions' => 'Hromadné akce',
        'approved' => 'Schválit',
        'approved_question' => 'Opravdu chcete schválit vybrané rezervace?',
        'closed' => 'Uzavřít',
        'closed_question' => 'Opravdu chcete uzavřít vybrané rezervace?',
        'received' => 'Přijato',
        'received_question' => 'Opravdu chcete nastavit vybrané rezervace jako přijaté?',
        'cancelled' => 'Zrušit',
        'cancelled_question' => 'Opravdu chcete zrušit vybrané rezervace?',
        'delete' => 'Vymazat',
        'delete_question' => 'Opravdu chcete vymazat vybrané rezervace?',
        'change_status_success' => 'Stav rezervací byl úspěšně upraven.',
    ],

    'reservation' => [
        'date' => 'Datum',
        'time' => 'Čas',
        'date_format' => 'd.m.Y H:i:s',
        'name' => 'Jméno',
        'email' => 'E-mail',
        'phone' => 'Telefon',
        'status' => 'Status',
        'created_at' => 'Vytvořena',
        'created_at_format' => 'd.m.Y H:i:s',
        'street' => 'Adresa / ulice',
        'message' => 'Zpráva',
        'number' => 'Číslo',
        'returning' => 'Opakovaný',
        'submit' => 'Odeslat',
    ],

    'statuses' => [
        'menu_label' => 'Statusy',
        'change_order' => 'Upravit pořadí',
    ],

    'status' => [
        'name' => 'Status',
        'color' => 'Barva',
        'ident' => 'Identifikátor',
        'order' => 'Pořadí',
        'enabled' => 'Aktivní',
        'created' => 'Vytvořen',
        'created_format' => 'd.m.Y H:i:s',
        'updated' => 'Upraven',
        'updated_format' => 'd.m.Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Export',
        'status_filter' => 'Filtrování statusu',
        'status_filter_label' => 'Status',
        'status_filter_tab' => 'Status',
    ],

    'reservationform' => [
        'name' => 'Rezervační formulář',
        'description' => 'Formulář pro vytvoření nové rezervace.',
        'success' => 'Rezervace byla úspěšně odeslána!',
    ],

    'mail' => [
        'cs_label' => 'Potvrzení rezervace CS',
        'en_label' => 'Potvrzení rezervace EN',
        'es_label' => 'Potvrzení rezervace ES',
        'fr_label' => 'Potvrzení rezervace FR',
        'ru_label' => 'Potvrzení rezervace RU',
    ],

    'errors' => [
        'empty_date' => 'Musíte vybrat datum!',
        'empty_hour' => 'Musíte vybrat čas!',
        'please_wait' => 'Můžete odeslat rezervaci pouze jednou za 30 sekund. Prosím počkejte chvilku.',
        'session_expired' => 'Platnost formuláře vypršela, prosíme obnovte stránku.',
        'exception' => 'Omlouváme se, ale něco se pokazilo a rezervační formulář nelze odeslat.',
        'already_booked' => 'Datum :reservation je již zarezervováno.',
        'days_off' => 'Vybraný den není pracovní. Vyberte prosím některý z pracovních dní.',
        'out_of_hours' => 'Vybraná hodina není v pracovních hodinách. Vyberte prosím některou z pracovních hodin.',
        'past_date' => 'Vyberte prosím datum a čas z budoucnosti.',
    ],

    'settings' => [
        'description' => 'Správa a nastavení rezervací.',
        'tabs' => [
            'plugin'  => 'Nastavení rezervací',
            'admin'   => 'Potvrzení správci',
            'datetime' => 'Nastavení kalendáře',
            'returning' => 'Opakovaný nákup',
            'working_days' => 'Pracovní dny',
        ],

        'returning_mark' => [
            'label'   => 'Označit vracející se zákazníky',
            'comment' => 'Označí zákazníky kteří koupili daný počet rezervací, nebo více. Pro vypnutí označení zadejte 0.',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Posílat e-mailové potvrzení správci stránek',
        ],
        'admin_confirmation_email' => [
            'label'   => 'E-mail správce',
            'comment' => 'E-mail správce pro zasílání potvrzení.',
        ],
        'admin_confirmation_name' => [
            'label'   => 'Jméno správce',
            'comment' => 'Jméno správce pro potvrzující e-mail.',
        ],
        'admin_confirmation_locale' => [
            'label'   => 'Jazyk e-mailového potvrzení spráci',
            'comment' => 'Jazyková mutace e-mailu který je zasílán správci (cs, en, es, ru).',
        ],
        'reservation_interval' => [
            'label'   => 'Časový slot pro rezervace (v minutách)',
            'comment' => 'Nejmenší časová jednotka používaná pro výběr času. Typicky 15 minut.',
        ],
        'reservation_length' => [
            'label'   => 'Délka jedné rezervace',
            'comment' => 'Jak dlouho zabere jedna rezervace.',
        ],
        'reservation_length_unit' => [
            'options' => [
                'minutes' => 'minuty',
                'hours' => 'hodiny',
                'days' => 'dny',
                'weeks' => 'týdny',
            ],
        ],
        'formats_date' => [
            'label'   => 'Formát data',
            'comment' => 'Povolené znaky: d, dd, ddd, dddd, m, mm, mmm, mmmm, yy, yyyy, Y',
        ],
        'formats_time' => [
            'label'   => 'Formát času',
            'comment' => 'Povolené znaky: h, hh, H, HH, i, a, A',
        ],
        'first_weekday' => [
            'label'   => 'Je první den v týdnu pondělí?',
        ],
        'work_time_from' => [
            'label'   => 'Začátek pracovní doby',
            'comment' => 'Zadávejte ve formátu HH:mm (24 hodinový formát)',
        ],
        'work_time_to' => [
            'label'   => 'Konec pracovní doby',
            'comment' => 'Zadávejte ve formátu HH:mm (24 hodinový formát)',
        ],
        'work_days' => [
            'label'     => 'Pracovní dny',
            'monday'    => 'Pondělí',
            'tuesday'   => 'Úterý',
            'wednesday' => 'Středa',
            'thursday'  => 'Čtvrtek',
            'friday'    => 'Pátek',
            'saturday'  => 'Sobota',
            'sunday'    => 'Neděle',
        ],
    ],
];
