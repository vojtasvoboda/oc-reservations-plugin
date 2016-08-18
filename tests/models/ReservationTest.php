<?php namespace VojtaSvoboda\Reservations\Tests\Models;

use App;
use Config;
use PluginTestCase;

class ReservationTest extends PluginTestCase
{
    public function getModel()
    {
        return App::make('VojtaSvoboda\Reservations\Models\Reservation');
    }

    public function testGetHash()
    {
        $model = $this->getModel();

        $firstHash = $model->getUniqueHash();
        $secondHash = $model->getUniqueHash();

        $this->assertNotEquals($firstHash, $secondHash);
    }

    public function testGetNumber()
    {
        $model = $this->getModel();

        $firstNumber = $model->getUniqueNumber();
        $secondNumber = $model->getUniqueNumber();

        $this->assertNotEquals($firstNumber, $secondNumber);
    }
}
