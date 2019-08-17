<?php

return [

    'plugin' => [
        'name' => 'Reservas',
        'category' => 'Reservas',
        'description' => 'Plugin de reservas rápidas.',
        'menu_label' => 'Reservas',
    ],

    'permission' => [
        'tab_label' => 'Reservas',
        'reservations' => 'Gestión de reservas',
        'statuses' => 'Gestión de estados',
        'export' => 'Exportar reservas',
    ],

    'reservations' => [
        'menu_label' => 'Reservas',
        'widget_label' => 'Reservas',
        'bulk_actions' => 'Acciones en lote',
        'approved' => 'Aprobada',
        'approved_question' => '¿Estás seguro de marcar reservas como Aprobadas?',
        'closed' => 'Cerrada',
        'closed_question' => '¿Estás seguro de marcar reservas como Cerradas?',
        'received' => 'Recibida',
        'received_question' => '¿Estás seguro de marcar reservas como Recibidas?',
        'cancelled' => 'Cancelada',
        'cancelled_question' => '¿Estás seguro de marcar reservas como Canceladas?',
        'delete' => 'Eliminar',
        'delete_question' => '¿Estás seguro de eliminar las reservas seleccionadas?',
        'change_status_success' => 'El estado de las reservas ha sido cambiado correctamente.',
    ],

    'reservation' => [
        'date' => 'Fecha',
        'date_format' => 'd/m/Y H:i:s',
        'name' => 'Nombre',
        'email' => 'Email',
        'phone' => 'Teléfono',
        'status' => 'Estado',
        'created_at' => 'Creada el',
        'created_at_format' => 'd/m/Y H:i:s',
        'street' => 'Dirección / Calle',
        'message' => 'Mensaje',
    ],

    'statuses' => [
        'menu_label' => 'Estados',
        'change_order' => 'Cambiar orden',
    ],

    'status' => [
        'name' => 'Estado',
        'color' => 'Color',
        'ident' => 'Ident',
        'order' => 'Orden',
        'enabled' => 'Activado',
        'created' => 'Creado',
        'created_format' => 'd/m/Y H:i:s',
        'updated' => 'Actualizado',
        'updated_format' => 'd/m/Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Exportar',
        'status_filter' => 'Filtrar por estado',
        'status_filter_label' => 'Estado',
        'status_filter_tab' => 'Estado',
    ],

    'reservationform' => [
        'name' => 'Formulario de reserva',
        'description' => 'Formulario para tomar reservas en una fecha y hora específicas.',
        'success' => '¡La reserva ha sido correctamente enviada!',
    ],

    'mail' => [
        'cs_label' => 'Reservation confirmation CS',
        'en_label' => 'Reservation confirmation EN',
        'es_label' => 'Reservation confirmation ES',
        'fr_label' => 'Reservation confirmation FR',
        'ru_label' => 'Reservation confirmation RU',
    ],
];
