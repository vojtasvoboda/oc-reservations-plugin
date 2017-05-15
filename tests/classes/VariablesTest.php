<?php namespace VojtaSvoboda\Reservations\Tests\Variables;

use PluginTestCase;
use VojtaSvoboda\Reservations\Classes\Variables;
use VojtaSvoboda\Reservations\Models\Settings;

class VariablesTest extends PluginTestCase
{
    public function testGetDateTime()
    {
        $result = Variables::getDateTimeFormat();
        $this->assertSame('d/m/Y H:i', $result);
    }

    public function testGetReservationLength()
    {
        $result = Variables::getReservationLength();
        $this->assertSame('2 hours', $result);
    }

    public function testGetReservationLengthAfterSet()
    {
        Settings::set('reservation_length', 90);
        Settings::set('reservation_length_unit', 'minutes');
        $result = Variables::getReservationLength();
        $this->assertSame('90 minutes', $result);
    }
}
