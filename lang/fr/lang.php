<?php

return [

    'plugin' => [
        'name' => 'Reservations',
        'category' => 'Reservations',
        'description' => 'Plugin de réservation rapide.',
        'menu_label' => 'Reservations',
    ],

    'permission' => [
        'tab_label' => 'Reservations',
        'reservations' => 'Gestion des réservations',
        'statuses' => 'Gestion des statuts',
        'export' => 'Exportation des réservations',
    ],

    'reservations' => [
        'menu_label' => 'Reservations',
        'widget_label' => 'Reservations',
        'bulk_actions' => 'Actions en bloc',
        'approved' => 'Approuver',
        'approved_question' => 'Êtes-vous sûr de marquer les réservations comme Approuvées ?',
        'closed' => 'Fermer',
        'closed_question' => 'Êtes-vous sûr de marquer les réservations comme Fermées ?',
        'received' => 'Reçue',
        'received_question' => 'Êtes-vous sûr de marquer les réservations comme Reçues ?',
        'cancelled' => 'Annuler',
        'cancelled_question' => 'Êtes-vous sûr de marquer les réservations comme Annulées ?',
        'delete' => 'Supprimer',
        'delete_question' => 'Êtes-vous sûr de supprimer les réservations sélectionnées ?',
        'change_status_success' => 'Les états des réservations ont été modifiés avec succès.',
    ],

    'reservation' => [
        'date' => 'Date',
        'time' => 'Heure',
        'date_format' => 'd.m.Y H:i:s',
        'name' => 'Nom',
        'email' => 'Email',
        'phone' => 'Téléphone',
        'status' => 'Status',
        'created_at' => 'Créé à',
        'created_at_format' => 'd.m.Y H:i:s',
        'street' => 'Adresse / rue',
        'message' => 'Message',
        'number' => 'Numéro',
        'returning' => 'Revenir en arrière',
        'submit' => 'Soumettre',
    ],

    'statuses' => [
        'menu_label' => 'Statuts',
        'change_order' => 'Changer l\'ordre',
    ],

    'status' => [
        'name' => 'Statuts',
        'color' => 'Couleur',
        'ident' => 'Identification',
        'order' => 'Ordre de tri',
        'enabled' => 'Activé',
        'created' => 'Créé',
        'created_format' => 'd.m.Y H:i:s',
        'updated' => 'Mise à jour',
        'updated_format' => 'd.m.Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Exporter',
        'status_filter' => 'Filtrer par statut',
        'status_filter_label' => 'Statuts',
        'status_filter_tab' => 'Statuts',
    ],

    'reservationform' => [
        'name' => 'Formulaire de réservation',
        'description' => 'Formulaire de prise de réservation à une date/heure précise.',
        'success' => 'La réservation a été envoyée avec succès !',
    ],

    'mail' => [
        'cs_label' => 'Confirmation de réservation CS',
        'en_label' => 'Confirmation de réservation EN',
        'es_label' => 'Confirmation de réservation ES',
        'fr_label' => 'Confirmation de réservation FR',
        'ru_label' => 'Confirmation de réservation RU',
    ],

    'errors' => [
        'empty_date' => 'Vous devez choisir une date !',
        'empty_hour' => 'Vous devez choisir une heure !',
        'please_wait' => 'Vous ne pouvez envoyer qu\'une seule réservation par 30 secondes, veuillez patienter un instant.',
        'session_expired' => 'Session de formulaire expirée ! Veuillez rafraîchir la page.',
        'exception' => 'Nous sommes désolés, mais il y a eu un problème et le formulaire ne peut pas être envoyé.',
        'already_booked' => 'La date :réservation est déjà réservée.',
        'days_off' => 'La date sélectionnée est un jour férié.',
        'out_of_hours' => 'L\'heure sélectionnée est en dehors des heures d\'ouverture.',
        'past_date' => 'La date sélectionnée est passée.',
    ],

    'settings' => [
        'description' => 'Gérer les paramètres de réservation.',
        'tabs' => [
            'plugin'  => 'Paramètres de réservation',
            'admin'   => 'Confirmation admin',
            'datetime' => 'Réglage date/heure',
            'returning' => 'Fidélisation',
            'working_days' => 'Jours travaillés',
        ],

        'returning_mark' => [
            'label'   => 'Marquer les clients qui reviennent',
            'comment' => 'Marquez les clients avec ce nombre de réservations ou plus. Désactiver par la valeur 0.',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Activer la confirmation à l\'administrateur',
        ],
        'admin_confirmation_email' => [
            'label'   => 'Email administrateur',
            'comment' => 'Email de l\'administrateur pour l\'envoi de la confirmation.',
        ],
        'admin_confirmation_name' => [
            'label'   => 'Nom administrateur',
            'comment' => 'Nom de l\'administrateur pour l\'email de confirmation.',
        ],
        'admin_confirmation_locale' => [
            'label'   => 'Langue de la confirmation',
            'comment' => 'Langue de l\'email de confirmation.',
        ],
        'reservation_interval' => [
            'label'   => 'Intervalle de réservation (minute)',
            'comment' => 'Utilisé pour le formulaire de réservation du sélecteur de temps.',
        ],
        'reservation_length' => [
            'label'   => 'Durée d\'une réservation',
            'comment' => 'Combien de temps prend une réservation ?',
        ],
        'reservation_length_unit' => [
            'options' => [
                'minutes' => 'minutes',
                'hours' => 'heures',
                'days' => 'jours',
                'weeks' => 'semaines',
            ],
        ],
        'formats_date' => [
            'label'   => 'Format de la date',
            'comment' => 'Vous pouvez utiliser: d, dd, ddd, dddd, m, mm, mmm, mmmm, yy, yyyy, Y',
        ],
        'formats_time' => [
            'label'   => 'Format de l\'heure',
            'comment' => 'Vous pouvez utiliser: h, hh, H, HH, i, a, A',
        ],
        'first_weekday' => [
            'label'   => 'Le premier jour de la semaine est lundi ?',
        ],
        'work_time_from' => [
            'label'   => 'Commence à travailler à partir de',
            'comment' => 'Temps formaté HH:mm (format 24 heures)',
        ],
        'work_time_to' => [
            'label'   => 'Finis de travailler à',
            'comment' => 'Temps formaté HH:mm (format 24 heures)',
        ],
        'work_days' => [
            'label'   => 'Jours travaillés',
            'monday'    => 'Lundi',
            'tuesday'   => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday'  => 'Jeudi',
            'friday'    => 'Vendredi',
            'saturday'  => 'Samedi',
            'sunday'    => 'Dimanche',
        ],
    ],
];
