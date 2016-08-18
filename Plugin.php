<?php namespace VojtaSvoboda\Reservations;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        $this->app->bind('reservations', 'VojtaSvoboda\Reservations\Facades\ReservationsFacade');
    }

    public function registerNavigation()
    {
        return [
            'reservations' => [
                'label'       => 'Rezervace',
                'url'         => Backend::url('vojtasvoboda/reservations/reservations'),
                'icon'        => 'icon-calendar-o',
                'permissions' => ['vojtasvoboda.reservations.*'],
                'order'       => 500,
                'sideMenu' => [
                    'reservations' => [
                        'label' => 'Rezervace',
                        'url' => Backend::url('vojtasvoboda/reservations/reservations'),
                        'icon' => 'icon-calendar-o',
                        'permissions' => ['vojtasvoboda.reservations.reservations'],
                        'order' => 100,
                    ],
                    'statuses' => [
                        'label' => 'Statusy',
                        'icon' => 'icon-star',
                        'url' => Backend::url('vojtasvoboda/reservations/statuses'),
                        'permissions' => ['vojtasvoboda.reservations.statuses'],
                        'order' => 200,
                    ],
                    'export' => [
                        'label' => 'Export',
                        'icon' => 'icon-sign-out',
                        'url' => Backend::url('vojtasvoboda/reservations/reservations/export'),
                        'permissions' => ['vojtasvoboda.reservations.export'],
                        'order' => 300,
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
}
