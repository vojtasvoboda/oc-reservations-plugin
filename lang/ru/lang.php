<?php

return [

    'plugin' => [
        'name' => 'Бронирование',
        'description' => 'Плагин быстрого бронирования.',
        'menu_label' => 'Бронирование',
    ],

    'permission' => [
        'tab_label' => 'Бронирование',
        'reservations' => 'Управление бронями',
        'statuses' => 'Управление статусами',
        'export' => 'Экспорт броней',
    ],

    'reservations' => [
        'menu_label' => 'Бронирование',
        'widget_label' => 'Бронирование',
        'bulk_actions' => 'Bulk actions',
        'approved' => 'Подтвердить',
        'approved_question' => 'Вы уверены, что хотите подтвердить брони?',
        'closed' => 'Закрыть',
        'closed_question' => 'Вы уверены, что хотите закрыть брони?',
        'received' => 'Сброить',
        'received_question' => 'Вы уверены, что хотите сбросить брони?',
        'cancelled' => 'Отменить',
        'cancelled_question' => 'Вы уверены, что хотите отменить брони?',
        'delete' => 'Удалить',
        'delete_question' => 'Are you sure to delete selected reservations?',
        'change_status_success' => 'Reservation states has been successfully changed.',
    ],

    'reservation' => [
        'date' => 'Дата',
        'date_format' => 'd.m.Y H:i:s',
        'name' => 'Имя',
        'email' => 'Email',
        'phone' => 'Телефон',
        'status' => 'Статус',
        'created_at' => 'Создано',
        'created_at_format' => 'd.m.Y H:i:s',
        'street' => 'Адрес / улица',
        'message' => 'Комментарий',
        'number' => 'Номер',
        'returning' => 'Returning',
    ],

    'statuses' => [
        'menu_label' => 'Статусы',
        'change_order' => 'Изменить порядок',
    ],

    'status' => [
        'name' => 'Статус',
        'color' => 'Цвет',
        'ident' => 'ID',
        'order' => 'Порядок сортировки',
        'enabled' => 'Включен',
        'created' => 'Создан',
        'created_format' => 'd.m.Y H:i:s',
        'updated' => 'Обновлён',
        'updated_format' => 'd.m.Y H:i:s',
    ],

    'export' => [
        'menu_label' => 'Выгрузить',
        'status_filter' => 'Отфильтровать по статусам',
        'status_filter_label' => 'Статусы',
        'status_filter_tab' => 'Статусы',
    ],

    'reservationform' => [
        'name' => 'Форма бронирования',
        'description' => 'Форма для бронирования в определенную дату/время.',
        'success' => 'Бронирование успешно отправленно!',
    ],

    'mail' => [
        'cs_label' => 'Подтверждение резервирования CS',
        'en_label' => 'Подтверждение резервирования EN',
        'es_label' => 'Подтверждение резервирования ES',
        'ru_label' => 'Подтверждение резервирования RU',
    ],
];
