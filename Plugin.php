<?php namespace VojtaSvoboda\Reservations;

use Backend;
use Illuminate\Support\Facades\Validator;
use System\Classes\PluginBase;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Validators\ReservationsValidators;

class Plugin extends PluginBase
{
    public function boot()
    {
        $this->app->bind('vojtasvoboda.reservations.facade', ReservationsFacade::class);

        // registrate reservations validators
        Validator::resolver(function($translator, $data, $rules, $messages, $customAttributes) {
            return new ReservationsValidators($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    public function registerNavigation()
    {
        return [
            'reservations' => [
                'label'       => 'vojtasvoboda.reservations::lang.plugin.menu_label',
                'url'         => Backend::url('vojtasvoboda/reservations/reservations'),
                'icon'        => 'icon-calendar-o',
                'permissions' => ['vojtasvoboda.reservations.*'],
                'order'       => 500,
                'sideMenu' => [
                    'reservations' => [
                        'label'       => 'vojtasvoboda.reservations::lang.reservations.menu_label',
                        'url'         => Backend::url('vojtasvoboda/reservations/reservations'),
                        'icon'        => 'icon-calendar-o',
                        'permissions' => ['vojtasvoboda.reservations.reservations'],
                        'order'       => 100,
                    ],
                    'statuses' => [
                        'label'       => 'vojtasvoboda.reservations::lang.statuses.menu_label',
                        'icon'        => 'icon-star',
                        'url'         => Backend::url('vojtasvoboda/reservations/statuses'),
                        'permissions' => ['vojtasvoboda.reservations.statuses'],
                        'order'       => 200,
                    ],
                    'export' => [
                        'label'       => 'vojtasvoboda.reservations::lang.export.menu_label',
                        'icon'        => 'icon-sign-out',
                        'url'         => Backend::url('vojtasvoboda/reservations/reservations/export'),
                        'permissions' => ['vojtasvoboda.reservations.export'],
                        'order'       => 300,
                    ],
                ],
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            'VojtaSvoboda\Reservations\Components\ReservationForm' => 'reservationForm',
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'VojtaSvoboda\Reservations\ReportWidgets\Reservations' => [
                'label'   => 'vojtasvoboda.reservations::lang.reservations.widget_label',
                'context' => 'dashboard',
            ],
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'vojtasvoboda.reservations::mail.reservation-cs' => 'Reservation confirmation CS',
            'vojtasvoboda.reservations::mail.reservation-en' => 'Reservation confirmation EN',
            'vojtasvoboda.reservations::mail.reservation-es' => 'Reservation confirmation ES',
            'vojtasvoboda.reservations::mail.reservation-fr' => 'Reservation confirmation FR',
            'vojtasvoboda.reservations::mail.reservation-ru' => 'Reservation confirmation RU',
            'vojtasvoboda.reservations::mail.reservation-admin-cs' => 'Reservation confirmation for admin CS',
            'vojtasvoboda.reservations::mail.reservation-admin-en' => 'Reservation confirmation for admin EN',
            'vojtasvoboda.reservations::mail.reservation-admin-es' => 'Reservation confirmation for admin ES',
            'vojtasvoboda.reservations::mail.reservation-admin-fr' => 'Reservation confirmation for admin FR',
            'vojtasvoboda.reservations::mail.reservation-admin-ru' => 'Reservation confirmation for admin RU',
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'category' => 'vojtasvoboda.reservations::lang.plugin.category',
                'label' => 'vojtasvoboda.reservations::lang.plugin.name',
                'description' => 'vojtasvoboda.reservations::lang.settings.description',
                'icon' => 'icon-calendar-o',
                'class' => 'VojtaSvoboda\Reservations\Models\Settings',
                'order' => 100,
            ],
        ];
    }
}
