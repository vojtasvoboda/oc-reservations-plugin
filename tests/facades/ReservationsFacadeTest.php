<?php namespace VojtaSvoboda\Reservations\Tests\Facades;

use App;
use Carbon\Carbon;
use Config;
use PluginTestCase;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Settings;
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
        return App::make(ReservationsFacade::class);
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

    public function testTransformDateTime()
    {
        $model = $this->getModel();

        $data = [
            'date' => '08/10/2016',
            'time' => '15:45',
        ];
        $date = $model->transformDateTime($data);

        $this->assertInstanceOf('Carbon\Carbon', $date);
        $this->assertEquals('2016-10-08 15:45:00', $date->format('Y-m-d H:i:s'));
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

    public function testGetReservationsCountByMail()
    {
        $model = $this->getModel();

        // create one reservation with test@test.cz email
        $model->storeReservation($this->getTestingReservationData());

        $count = $model->getReservationsCountByMail('vojtasvoboda.cz@gmail.com');
        $this->assertEquals(0, $count);

        $count = $model->getReservationsCountByMail('test@test.cz');
        $this->assertEquals(1, $count);
    }

    public function testIsUserReturning()
    {
        $model = $this->getModel();

        // enable Returning Customers function
        Settings::set('returning_mark', 1);

        // is returning without any reservation?
        $isReturning = $model->isUserReturning('test@test.cz');
        $this->assertEquals(false, $isReturning, 'There is no reservation, so customer cant be returning.');

        // create one reservation with test@test.cz email
        $model->storeReservation($this->getTestingReservationData());

        // is returning without any reservation?
        $isReturning = $model->isUserReturning('vojtasvoboda.cz@gmail.com');
        $this->assertEquals(false, $isReturning, 'Email vojtasvoboda.cz@gmail.com does not has any reservation, so it should not be marked as returning customer.');

        // is returning with one reservation?
        $isReturning = $model->isUserReturning('test@test.cz');
        $this->assertEquals(true, $isReturning, 'Email test@test.cz has one reservation, so it should be marked as returning customer.');
    }

    public function testIsCreatedWhileAgo()
    {
        $model = $this->getModel();
        $exists = $model->isCreatedWhileAgo();

        $this->assertFalse($exists);

        // create fake reservation
        $model->storeReservation($this->getTestingReservationData());
        $exists = $model->isCreatedWhileAgo();

        $this->assertTrue($exists);
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
