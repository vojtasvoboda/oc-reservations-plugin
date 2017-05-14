<?php namespace VojtaSvoboda\Reservations\Tests\Models;

use App;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\Validator;
use PluginTestCase;
use October\Rain\Database\ModelException;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Status;
use VojtaSvoboda\Reservations\Validators\ReservationsValidators;

class ReservationTest extends PluginTestCase
{
    private $defaultStatus;

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
     * Get tested model.
     *
     * @return Reservation
     */
    public function getModel()
    {
        return App::make(Reservation::class);
    }

    public function testBeforeCreate()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->create($this->getTestingReservationData());
        $this->assertNotEmpty($reservation->hash, 'Reservation hash is empty.');
        $this->assertNotEmpty($reservation->number, 'Number hash is empty.');
        $this->assertSame(App::getLocale(), $reservation->locale, 'Reservation locale should be same as app locale.');
        $this->assertNotEmpty($reservation->ip, 'IP address is empty.');
        $this->assertNotEmpty($reservation->user_agent, 'User Agent is empty.');
        $this->assertSame($this->getDefaultStatus(), $reservation->status, 'Reservation status should be ' . $this->getDefaultStatus()->name . '.');
    }

    public function testIsDateAvailableFailing()
    {
        $model = $this->getModel();

        // create reservation
        $model->create($this->getTestingReservationData());

        // try to do second reservation with same date and time
        $this->setExpectedException(ModelException::class, 'vojtasvoboda.reservations::lang.errors.already_booked');
        $model->create($this->getTestingReservationData());
    }

    public function testIsDateAvailablePassed()
    {
        $model = $this->getModel();

        // create reservation
        $model->create($this->getTestingReservationData());

        // try to do second reservation with same date and time after 2 hours
        $data = $this->getTestingReservationData();
        $nextMonday = Carbon::parse('next monday')->format('Y-m-d 13:00');
        $data['date'] = Carbon::createFromFormat('Y-m-d H:i', $nextMonday);
        $model->create($data);
    }

    public function testIsDateAvailableForCancelled()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->create($this->getTestingReservationData());

        // cancel status
        $cancelledStatuses = Config::get('vojtasvoboda.reservations::config.statuses.cancelled', ['cancelled']);
        $statusIdent = empty($cancelledStatuses) ? 'cancelled' : $cancelledStatuses[0];

        // cancell reservation
        $reservation->status = Status::where('ident', $statusIdent)->first();
        $reservation->save();

        // try to do second reservation with same date and time
        $data = $this->getTestingReservationData();
        $model->create($data);
    }

    public function testIsCancelled()
    {
        $model = $this->getModel();

        $reservation = $model->create($this->getTestingReservationData());
        $this->assertFalse($reservation->isCancelled());
        $this->assertTrue($reservation->isCancelled('cancelled'));
    }

    public function testGetHash()
    {
        $model = $this->getModel();

        $firstHash = $model->getUniqueHash();
        $secondHash = $model->getUniqueHash();

        $this->assertNotEquals($firstHash, $secondHash);
    }

    public function testGetEmptyHash()
    {
        $model = $this->getModel();
        Config::set('vojtasvoboda.reservations::config.hash', 0);
        $this->assertNull($model->getUniqueHash());
    }

    public function testGetNumber()
    {
        $model = $this->getModel();

        $firstNumber = $model->getUniqueNumber();
        $secondNumber = $model->getUniqueNumber();

        $this->assertNotEquals($firstNumber, $secondNumber);
    }

    public function testGetEmptyNumber()
    {
        $model = $this->getModel();
        Config::set('vojtasvoboda.reservations::config.number.min', 0);
        $this->assertNull($model->getUniqueNumber());
    }

    public function testScopeNotCancelled()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->create($this->getTestingReservationData());
        $reservations = $model->notCancelled()->get();
        $this->assertNotEmpty($reservations);

        // change reservation to cancelled
        $reservation->status = Status::where('ident', 'cancelled')->first();
        $reservation->save();
        $reservations = $model->notCancelled()->get();
        $this->assertEmpty($reservations);
    }

    public function testScopeCurrentDate()
    {
        $model = $this->getModel();

        // create reservation
        $reservation = $model->create($this->getTestingReservationData());
        $reservations = $model->currentDate()->get();
        $this->assertNotEmpty($reservations);

        // change reservation to the past
        $reservation->date = Carbon::parse('-1 month');
        $reservation->save();
        $reservations = $model->currentDate()->get();
        $this->assertEmpty($reservations);
    }

    /**
     * Get testing reservation data.
     *
     * @return array
     */
    private function getTestingReservationData()
    {
        $nextMonday = Carbon::parse('next monday')->format('Y-m-d 11:00');

        return [
            'date' => Carbon::createFromFormat('Y-m-d H:i', $nextMonday),
            'email' => 'test@test.cz',
            'phone' => '777111222',
            'street' => 'ABCDE',
            'name' => 'Vojta Svoboda',
            'message' => 'Hello.',
            'status' => $this->getDefaultStatus(),
        ];
    }

    /**
     * Get default status object.
     *
     * @return mixed
     */
    private function getDefaultStatus()
    {
        if ($this->defaultStatus === null) {
            $statusIdent = 'received';
            $this->defaultStatus = Status::where('ident', $statusIdent)->first();
        }

        return $this->defaultStatus;
    }
}
