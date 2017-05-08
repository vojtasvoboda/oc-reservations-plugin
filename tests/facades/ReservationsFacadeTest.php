<?php namespace VojtaSvoboda\Reservations\Tests\Facades;

use App;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\Validator;
use PluginTestCase;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Settings;
use VojtaSvoboda\Reservations\Validators\ReservationsValidators;

class ReservationsFacadeTest extends PluginTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->app->bind('vojtasvoboda.reservations.facade', ReservationsFacade::class);

        // registrate reservations validators
        Validator::resolver(function($translator, $data, $rules, $messages, $customAttributes) {
            return new ReservationsValidators($translator, $data, $rules, $messages, $customAttributes);
        });
    }

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
            'date' => (new \DateTime('next monday'))->format('d/m/Y'),
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
        $testingData = $this->getTestingReservationData();
        $inputDate = $testingData['date'] . ' ' . $testingData['time'];
        $dateTime = Carbon::createFromFormat('d/m/Y H:i', $inputDate);
        $this->assertEquals($dateTime, $reservation->date);
    }

    public function testDoubleStoreReservationUnder30Seconds()
    {
        $model = $this->getModel();
        $testingData = $this->getTestingReservationData();
        $model->storeReservation($testingData);

        $this->setExpectedException('October\Rain\Exception\ApplicationException');
        $model->storeReservation($testingData);
    }

    public function testTransformDateTime()
    {
        $model = $this->getModel();

        $dateTime = new \DateTime('next monday');
        $data = [
            'date' => $dateTime->format('d/m/Y'),
            'time' => $dateTime->format('15:45'),
        ];
        $date = $model->transformDateTime($data);

        $this->assertInstanceOf('Carbon\Carbon', $date);
        $this->assertEquals($dateTime->format('Y-m-d').' 15:45:00', $date->format('Y-m-d H:i:s'));
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
        $dateTime = new \DateTime('next monday');

        return [
            'date' => $dateTime->format('d/m/Y'),
            'time' => $dateTime->format('11:00'),
            'email' => 'test@test.cz',
            'phone' => '777111222',
            'street' => 'ABCDE',
            'name' => 'Vojta Svoboda',
            'message' => 'Hello.',
        ];
    }
}
