<?php namespace VojtaSvoboda\Reservations\Validators;

use App;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Status;

/**
 * Custom Reservations validator.
 *
 * @package VojtaSvoboda\Reservations\Validators
 */
class ReservationsValidators extends Validator
{
    /**
     * Validate reservation. Called on date attribute. Validate date availability.
     *
     * Other available variables: $this->translator, $this->data, $this->rules a $this->messages.
     *
     * @param string $attribute Name of the validated field.
     * @param mixed $value Field value.
     *
     * @return bool
     */
	public function validateReservation($attribute, $value)
	{
	    if ($attribute === 'date') {
            return $this->validateDateAttribute($value);
        }

		return false;
	}

    /**
     * Validate date attribute.
     *
     * @param string $value
     *
     * @return bool
     */
	protected function validateDateAttribute($value)
    {
        $date = $this->getDateAsCarbon($value);
        $reservationId = isset($this->data['id']) ? $this->data['id'] : null;

        // disable validation for cancelled reservations
        if ($reservationId !== null) {
            $reservation = Reservation::findOrFail($reservationId);
            if ($this->isReservationCancelled($reservation)) {
                return true;
            }
        }

        return $this->getFacade()->isDateAvailable($date, $reservationId);
    }

    /**
     * Replace placeholder :reservation with custom text.
     *
     * @param string $message
     *
     * @return string
     */
    protected function replaceReservation($message)
    {
        $date = $this->getDateAsCarbon($this->data['date']);

        return str_replace(':reservation', $date->format('d.m.Y H:i'), $message);
    }

    /**
     * Returns if reservation is cancelled or going to be cancelled.
     *
     * @param Reservation $reservation
     *
     * @return bool
     */
    private function isReservationCancelled($reservation)
    {
        $futureStatus = Status::findOrFail($this->data['status_id']);

        return $reservation->isCancelled($futureStatus->ident);
    }

    /**
     * Get date as Carbon instance.
     *
     * @param string $date
     *
     * @return Carbon
     */
    private function getDateAsCarbon($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date);
    }

    /**
     * Get Reservations facade.
     *
     * @return ReservationsFacade
     */
    private function getFacade()
    {
        return App::make('vojtasvoboda.reservations.facade');
    }
}
