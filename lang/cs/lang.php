<?php

return [

    'plugin' => [
        'name' => 'Rezervace',
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
        'ru_label' => 'Potvrzení rezervace RU',
    ],

    'errors' => [
        'empty_date' => 'Musíte vybrat datum!',
        'empty_hour' => 'Musíte vybrat čas!',
        'please_wait' => 'Můžete odeslat rezervaci pouze jednou za 30 sekund. Prosím počkejte chvilku.',
        'session_expired' => 'Platnost formuláře vypršela, prosíme obnovte stránku.',
        'exception' => 'Omlouváme se, ale něco se pokazilo a rezervační formulář nelze odeslat.',
        'already_booked' => 'Datum :reservation je již zarezervováno.',
    ],

    'settings' => [
        'description' => 'Správa nastavení rezervací.',
        'tabs' => [
            'plugin'  => 'Nastavení rezervací',
            'admin'   => 'Potvrzení správci',
        ],

        'returning_mark' => [
            'label'   => 'Označit vracející se zákazníky',
            'comment' => 'Označit vracející se zákazníky s daným počtem rezervací, nebo více. Pro vypnutí zadejte nulu.',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Aktivovat potrvzení správci',
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
            'comment' => 'Jazyk e-mailu který je zasílán správci.',
        ],
    ],
];
