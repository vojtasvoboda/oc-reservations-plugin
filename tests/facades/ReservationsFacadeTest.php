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
        $nextMonday = Carbon::parse('next monday')->format('d/m/Y');
        $model->storeReservation([
            'date' => $nextMonday,
        ]);
    }

    public function testStoreReservationDaysOff()
    {
        $model = $this->getModel();
        $default = Settings::get('work_days', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']);
        Settings::set('work_days', []);

        $data = $this->getTestingReservationData();
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $dayOfWeek) {
            $exceptionTest = null;
            try {
                $data['date'] = Carbon::parse('next '.$dayOfWeek)->format('d/m/Y');
                $model->storeReservation($data);
            } catch (\Exception $exception) {
                $exceptionTest = $exception;
            }
            $this->assertEquals('October\Rain\Exception\ApplicationException', get_class($exceptionTest));
            $this->assertEquals('vojtasvoboda.reservations::lang.errors.days_off', $exceptionTest->getMessage());
        }

        Settings::set('work_days', $default);
    }

    public function testStoreReservationWorkingDays()
    {
        $default = Config::get('vojtasvoboda.reservations::config.protection_time', '-30 seconds');
        Config::set('vojtasvoboda.reservations::config.protection_time', '0 seconds');
        $model = $this->getModel();
        Settings::set('work_days', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);

        $data = $this->getTestingReservationData();
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $dayOfWeek) {
            $data['date'] = Carbon::parse('next '.$dayOfWeek)->format('d/m/Y');
            $model->storeReservation($data);
        }

        Config::set('vojtasvoboda.reservations::config.protection_time', $default);
    }

    public function testStoreReservationOutOfHours()
    {
        $model = $this->getModel();

        $data = $this->getTestingReservationData();
        $data['time'] = '19:00';

        $this->setExpectedException('October\Rain\Exception\ApplicationException');
        $model->storeReservation($data);
    }

    public function testStoreReservationInThePast()
    {
        $model = $this->getModel();

        $data = $this->getTestingReservationData();
        $data['date'] = Carbon::parse("last monday - 7 days")->format('d/m/Y');

        $this->setExpectedException('October\Rain\Exception\ApplicationException');
        $model->storeReservation($data);
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

        $nextMonday = Carbon::parse('next monday');
        $data = [
            'date' => $nextMonday->format('d/m/Y'),
            'time' => '15:45',
        ];
        $date = $model->transformDateTime($data);

        $this->assertInstanceOf('Carbon\Carbon', $date);
        $this->assertEquals($nextMonday->format('Y-m-d').' 15:45:00', $date->format('Y-m-d H:i:s'));
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
        $nextMonday = Carbon::parse('next monday')->format('d/m/Y');

        return [
            'date' => $nextMonday,
            'time' => '11:00',
            'email' => 'test@test.cz',
            'phone' => '777111222',
            'street' => 'ABCDE',
            'name' => 'Vojta Svoboda',
            'message' => 'Hello.',
        ];
    }
}
