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
    ],
];
