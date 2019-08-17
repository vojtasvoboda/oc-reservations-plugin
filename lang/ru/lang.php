<?php

return [

    'plugin' => [
        'name' => 'Бронирование',
        'category' => 'Бронирование',
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
        'bulk_actions' => 'Массовые действия',
        'approved' => 'Подтвердить',
        'approved_question' => 'Вы уверены, что хотите подтвердить брони?',
        'closed' => 'Закрыть',
        'closed_question' => 'Вы уверены, что хотите закрыть брони?',
        'received' => 'Сброить',
        'received_question' => 'Вы уверены, что хотите сбросить брони?',
        'cancelled' => 'Отменить',
        'cancelled_question' => 'Вы уверены, что хотите отменить брони?',
        'delete' => 'Удалить',
        'delete_question' => 'Вы действительно хотите удалить выбранные брони?',
        'change_status_success' => 'Статус брони успешно изменён.',
    ],

    'reservation' => [
        'date' => 'Дата',
        'time' => 'Время',
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
        'returning' => 'Постоянный клиент',
        'submit' => 'Отправить',
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
        'fr_label' => 'Подтверждение резервирования FR',
        'ru_label' => 'Подтверждение резервирования RU',
    ],

    'errors' => [
        'empty_date' => 'Вы должны выбрать дату бронирования!',
        'empty_hour' => 'Вы должны выбрать время бронирования!',
        'please_wait' => 'Вы можете отправить только одно бронирование за 30 секунд, пожалуйста, подождите.',
        'session_expired' => 'Сессия формы истекла! Пожалуйства, обновите страницу.',
        'exception' => 'Сожалеем, но что-то пошло не так, и форма не может быть отправлена.',
        'already_booked' => 'Данное время :reservation уже занято.',
        'days_off' => 'Выбранный день - выходной.',
        'out_of_hours' => 'Выбранное время - не рабочее.',
        'past_date' => 'Выбрано прошедшее время.',
    ],

    'settings' => [
        'description' => 'Управление настройками бронирования',
        'tabs' => [
            'plugin'  => 'Настройки',
            'admin'   => 'Оповещение',
            'datetime' => 'Настройки времени',
            'returning' => 'Постоянный клиент',
            'working_days' => 'Время работы',
        ],

        'returning_mark' => [
            'label'   => 'Отметка постоянного клиента',
            'comment' => 'Отмечать клиента постоянным, если у него броней больше или равно указанному. Отключено при 0',
        ],
        'admin_confirmation_enable' => [
            'label'   => 'Включить оповещение администратора',
        ],
        'admin_confirmation_email' => [
            'label'   => 'Email администратора',
            'comment' => 'Email администратора для отправки оповещений.',
        ],
        'admin_confirmation_name' => [
            'label'   => 'Имя администратора',
            'comment' => 'Имя name администратора для отправки оповещений.',
        ],
        'admin_confirmation_locale' => [
            'label'   => 'Локаль для оповещения администратора',
            'comment' => 'Локаль шаблона для оповещения администратора.',
        ],
        'reservation_interval' => [
            'label'   => 'Интервал слотов для бронирования (в минутах)',
            'comment' => 'Используется для выбора времени резервирования.',
        ],
        'reservation_length' => [
            'label'   => 'Длина одной брони',
            'comment' => 'Сколько времени занимает одна бронь.',
        ],
        'reservation_length_unit' => [
            'options' => [
                'minutes' => 'минут',
                'hours' => 'часов',
                'days' => 'дней',
                'weeks' => 'недель',
            ],
        ],
        'formats_date' => [
            'label'   => 'Формат даты',
            'comment' => 'Используйте: d, dd, ddd, dddd, m, mm, mmm, mmmm, yy, yyyy, Y',
        ],
        'formats_time' => [
            'label'   => 'Формат времени',
            'comment' => 'Используйте: h, hh, H, HH, i, a, A',
        ],
        'first_weekday' => [
            'label'   => 'Неделя начинается с Понедельника?',
        ],
        'work_time_from' => [
            'label'   => 'Начало работы с',
            'comment' => 'Время в формате ЧЧ:ММ (24 часовой формат)',
        ],
        'work_time_to' => [
            'label'   => 'Окончание работы до',
            'comment' => 'Время в формате ЧЧ:ММ (24 часовой формат)',
        ],
        'work_days' => [
            'label'   => 'Рабочие дни',
            'monday'    => 'Понедельник',
            'tuesday'   => 'Вторник',
            'wednesday' => 'Среда',
            'thursday'  => 'Четверг',
            'friday'    => 'Пятница',
            'saturday'  => 'Суббота',
            'sunday'    => 'Воскресенье',
        ],
    ],
];
