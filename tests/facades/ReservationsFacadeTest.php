<?php namespace VojtaSvoboda\Reservations\Tests\Facades;

use App;
use Carbon\Carbon;
use Config;
use PluginTestCase;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;

class ReservationsFacadeTest extends PluginTestCase
{
    /**
     * Returns tested class.
     *
     * @return ReservationsFacade
     */
    public function getModel()
    {
        return App::make('VojtaSvoboda\Reservations\Facades\ReservationsFacade');
    }

    public function testStoreEmptyReservation()
    {
        $model = $this->getModel();

        $this->setExpectedException('October\Rain\Database\ModelException', 'The date field is required.');
        $model->storeReservation([]);
    }

    public function testStoreReservationWithoutTime()
    {
        $model = $this->getModel();

        $this->setExpectedException('October\Rain\Exception\ApplicationException');
        $model->storeReservation([
            'date' => '18/08/2016',
        ]);
    }

    public function testStoreReservation()
    {
        $model = $this->getModel();
        $reservation = $model->storeReservation($this->getTestingReservationData());

        // check status
        $defaultStatusIdent = Config::get('vojtasvoboda.reservations::config.statuses.received', 'received');
        $this->assertEquals($defaultStatusIdent, $reservation->status->ident);

        // check locale
        $locale = App::getLocale();
        $this->assertEquals($locale, $reservation->locale);

        // check date and time
        $inputDate = $this->getTestingReservationData()['date'] . ' ' . $this->getTestingReservationData()['time'];
        $dateTime = Carbon::createFromFormat('d/m/Y H:i', $inputDate)->toDateTimeString();
        $this->assertEquals($dateTime, $reservation->date);
    }

    private function getTestingReservationData()
    {
        return [
            'date' => '18/08/2016',
            'time' => '20:00',
            'email' => 'test@test.cz',
            'phone' => '777111222',
            'street' => 'ABCDE',
            'name' => 'Vojta Svoboda',
            'message' => 'Hello.',
        ];
    }
}
