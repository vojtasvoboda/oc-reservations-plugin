<?php namespace VojtaSvoboda\Reservations\Tests\Facades;

use App;
use Config;
use PluginTestCase;

class ReservationsFacadeTest extends PluginTestCase
{
    public function getModel()
    {
        return App::make('VojtaSvoboda\Reservations\Facades\GiftsFacade');
    }
}
