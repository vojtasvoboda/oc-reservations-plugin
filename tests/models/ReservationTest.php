<?php namespace VojtaSvoboda\Reservations\Tests\Models;

use App;
use Config;
use PluginTestCase;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Status;

class ReservationTest extends PluginTestCase
{
    /**
     * Get tested model.
     *
     * @return Reservation
     */
    public function getModel()
    {
        return App::make(Reservation::class);
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

    public function testIsExistsInLastTime()
    {
        $model = $this->getModel();
        $exists = $model->isExistInLastTime();

        $this->assertFalse($exists);

        // create fake reservation
        $model->create($this->getTestingReservationData());
        $exists = $model->isExistInLastTime();

        $this->assertTrue($exists);
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

    private function getTestingReservationData($statusIdent = 'received')
    {
        return [
            'date' => '2016-08-18 20:00',
            'email' => 'test@test.cz',
            'phone' => '777111222',
            'street' => 'ABCDE',
            'name' => 'Vojta Svoboda',
            'message' => 'Hello.',
            'status' => Status::where('ident', $statusIdent)->first(),
        ];
    }
}
