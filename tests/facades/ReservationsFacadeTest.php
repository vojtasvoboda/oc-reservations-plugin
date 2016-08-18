<?php namespace VojtaSvoboda\Reservations\Tests\Facades;

use App;
use Carbon\Carbon;
use Config;
use PluginTestCase;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Status;

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

        $this->setExpectedException('October\Rain\Exception\ApplicationException');
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

    public function testIsDateAvailableFailing()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->storeReservation($this->getTestingReservationData());

        // change created at date because of 30 seconds robots check
        $reservation->created_at = '2016-08-18 14:00:00';
        $reservation->save();

        // try to do second reservation with same date and time
        $this->setExpectedException('October\Rain\Exception\ApplicationException');
        $model->storeReservation($this->getTestingReservationData());
    }

    public function testIsDateAvailablePassed()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->storeReservation($this->getTestingReservationData());

        // change created at date because of 30 seconds robots check
        $reservation->created_at = '2016-08-18 14:00:00';
        $reservation->save();

        // try to do second reservation with same date and time after 2 hours
        $data = $this->getTestingReservationData();
        $data['time'] = '22:00';
        $model->storeReservation($data);
    }

    public function testIsDateAvailableForCancelled()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->storeReservation($this->getTestingReservationData());

        // cancel status
        $cancelledStatuses = Config::get('vojtasvoboda.reservations::config.statuses.cancelled', 'cancelled');
        $statusIdent = empty($cancelledStatuses) ? 'cancelled' : $cancelledStatuses[0];

        // change created at date because of 30 seconds robots check and cancell it
        $reservation->created_at = '2016-08-18 14:00:00';
        $reservation->status = Status::where('ident', $statusIdent)->first();
        $reservation->save();

        // try to do second reservation with same date and time
        $data = $this->getTestingReservationData();
        $model->storeReservation($data);
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
