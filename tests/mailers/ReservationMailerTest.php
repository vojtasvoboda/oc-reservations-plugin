<?php namespace VojtaSvoboda\Reservations\Tests\Mailers;

use App;
use PluginTestCase;
use VojtaSvoboda\Reservations\Mailers\ReservationMailer;

class ReservationsMailerTest extends PluginTestCase
{
    public function testStoreEmptyReservation()
    {
        $ident = ReservationMailer::getTemplateIdent();
        $locale = App::getLocale();

        $this->assertEquals('vojtasvoboda.reservations::mail.reservation-' . $locale, $ident);
    }
}
