<?php namespace VojtaSvoboda\Reservations\Components;

use App;
use Cms\Classes\ComponentBase;
use Config;
use Exception;
use Flash;
use Illuminate\Support\Facades\Log;
use Redirect;
use Input;
use Session;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;

class ReservationForm extends ComponentBase
{
    public function componentDetails()
	{
		return [
			'name' => 'Reservation form',
			'description' => 'Form for taking reservations in specific date/time.',
		];
	}

    /**
     * AJAX form submit by October JS Framework.
     */
    public function onSubmit()
    {
        if (Session::token() != Input::get('_token')) {
            throw new ApplicationException('Form session expired! Please refresh the page.');
        }

        /** @var ReservationsFacade $facade */
        $facade = App::make('reservations');
        $data = Input::all();
        $facade->storeReservation($data);
    }

    /**
     * Fallback for classic non-ajax POST request.
     *
     * @return mixed
     */
	public function onRun()
	{
        /** @var ReservationsFacade $facade */
        $facade = App::make('reservations');

		$error = false;
		if (Input::get('submit')) {

            if (Session::token() != Input::get('_token')) {
                $error = 'Form session expired! Please refresh the page.';

            } else {

                try {
                    $data = Input::all();
                    $facade->storeReservation($data);
                    Flash::success('Reservation has been successfully sent!');

                    return Redirect::to($this->page->url . '#form', 303);

                } catch(ValidationException $e) {
                    $error = $e->getMessage();

                } catch(ApplicationException $e) {
                    $error = $e->getMessage();

                } catch(Exception $e) {
                    Log::error($e->getMessage());
                    $error = 'We\'re sorry, but something went wrong and the page cannot be displayed.';
                }
            }
		}

		// inject assets
        $this->addCss('/plugins/vojtasvoboda/reservations/assets/css/classic.css');
        $this->addCss('/plugins/vojtasvoboda/reservations/assets/css/classic.date.css');
        $this->addCss('/plugins/vojtasvoboda/reservations/assets/css/classic.time.css');
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/picker.js');
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/picker.date.js');
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/picker.time.js');
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/reservationform.js');

		// load booked dates
        $dates = $facade->getReservedDates();

        // template data
		$this->page['sent'] = Flash::check();
		$this->page['post'] = $_POST;
		$this->page['error'] = $error;
        $this->page['dates'] = json_encode($dates);
	}
}
