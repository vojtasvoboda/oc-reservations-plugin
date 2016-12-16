<?php namespace VojtaSvoboda\Reservations\Tests\Mailers;

use App;
use PluginTestCase;
use VojtaSvoboda\Reservations\Mailers\BaseMailer;
use VojtaSvoboda\Reservations\Mailers\ReservationMailer;

class BaseMailerTest extends PluginTestCase
{
    /**
     * Get model.
     *
     * @return BaseMailer
     */
    public function getModel()
    {
        return App::make(BaseMailer::class);
    }

    public function testStoreEmptyReservation()
    {
        $model = $this->getModel();

        $ident = $model->getTemplateIdent('reservation');
        $locale = App::getLocale();

        $this->assertEquals('vojtasvoboda.reservations::mail.reservation-' . $locale, $ident);
    }
}
