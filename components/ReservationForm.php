<?php namespace VojtaSvoboda\Reservations\Components;

use App;
use Cms\Classes\ComponentBase;
use Exception;
use Flash;
use Illuminate\Support\Facades\Log;
use Input;
use Lang;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use Redirect;
use Session;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;

/**
 * Reservation Form component.
 *
 * @package VojtaSvoboda\Reservations\Components
 */
class ReservationForm extends ComponentBase
{
    const PATH_PICKADATE_COMPRESSED = '/plugins/vojtasvoboda/reservations/assets/vendor/pickadate/lib/compressed/';

    public function componentDetails()
	{
		return [
			'name' => 'vojtasvoboda.reservations::lang.reservationform.name',
			'description' => 'vojtasvoboda.reservations::lang.reservationform.description',
		];
	}

    /**
     * AJAX form submit handler.
     */
    public function onSubmit()
    {
        // check CSRF token
        if (Session::token() != Input::get('_token')) {
            throw new ApplicationException(Lang::get('vojtasvoboda.reservations::lang.errors.session_expired'));
        }

        $data = Input::all();
        $this->getFacade()->storeReservation($data);
    }

    /**
     * Fallback for non-ajax POST request.
     */
	public function onRun()
	{
        $facade = $this->getFacade();

		$error = false;
		if (Input::get($this->alias . '-submit')) {

            // check CSRF token
            if (Session::token() != Input::get('_token')) {
                $error = Lang::get('vojtasvoboda.reservations::lang.errors.session_expired');
            } else {
                try {
                    $data = Input::all();
                    $facade->storeReservation($data);
                    $msg = Lang::get('vojtasvoboda.reservations::lang.reservationform.success');
                    Flash::success($msg);

                    return Redirect::to($this->page->url . '#' . $this->alias, 303);

                } catch(ValidationException $e) {
                    $error = $e->getMessage();

                } catch(ApplicationException $e) {
                    $error = $e->getMessage();

                } catch(Exception $e) {
                    Log::error($e->getMessage());
                    $error = Lang::get('vojtasvoboda.reservations::lang.errors.exception');
                }
            }
		}

		// inject assets
        $this->injectAssets();

		// load booked dates and their time slots
        $dates = $this->getReservedDates();

        // template data
		$this->page['sent'] = Flash::check();
		$this->page['post'] = post();
		$this->page['error'] = $error;
        $this->page['dates'] = json_encode($dates);
	}

    /**
     * Get reservation facade.
     *
     * @return ReservationsFacade
     */
	protected function getFacade()
    {
        return App::make(ReservationsFacade::class);
    }

    /**
     * Get reserved dates.
     *
     * @return array
     */
    protected function getReservedDates()
    {
        return $this->getFacade()->getReservedDates();
    }

    /**
     * Inject components assets.
     */
    protected function injectAssets()
    {
        $this->addCss(self::PATH_PICKADATE_COMPRESSED.'themes/classic.css');
        $this->addCss(self::PATH_PICKADATE_COMPRESSED.'themes/classic.date.css');
        $this->addCss(self::PATH_PICKADATE_COMPRESSED.'themes/classic.time.css');
        $this->addJs(self::PATH_PICKADATE_COMPRESSED.'picker.js');
        $this->addJs(self::PATH_PICKADATE_COMPRESSED.'picker.date.js');
        $this->addJs(self::PATH_PICKADATE_COMPRESSED.'picker.time.js');

        switch (Lang::getLocale()) {
            case 'cs':
                $pickerTranslate = 'cs_CZ';
                break;
            case 'es':
                $pickerTranslate = 'es_ES';
                break;
            case 'ru':
                $pickerTranslate = 'ru_RU';
                break;
        }

        if (isset($pickerTranslate)) {
            $this->addJs(self::PATH_PICKADATE_COMPRESSED.'translations/'.$pickerTranslate.'.js');
        }

        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/reservationform.js');
    }
}
