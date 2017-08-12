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
use VojtaSvoboda\Reservations\Classes\Variables;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;

/**
 * Reservation Form component.
 *
 * @package VojtaSvoboda\Reservations\Components
 */
class ReservationForm extends ComponentBase
{
    const PATH_PICKADATE_COMPRESSED = '/plugins/vojtasvoboda/reservations/assets/vendor/pickadate/lib/compressed/';

    protected $pickerLang = [
        'cs' => 'cs_CZ',
        'es' => 'es_ES',
        'ru' => 'ru_RU',
        'fr' => 'fr_FR',
    ];

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
        if (Session::token() !== Input::get('_token')) {
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
            if (Session::token() !== Input::get('_token')) {
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
        $this->page['settings'] = $this->getCalendarSetting();
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
     * @return array
     */
    protected function getCalendarSetting()
    {
        return [
            'formats_date' => Variables::getDateFormat(),
            'formats_time' => Variables::getTimeFormat(),
            'reservation_interval' => Variables::getReservationInterval(),
            'first_weekday' => Variables::getFirstWeekday(),
            'work_time_from' => Variables::getWorkTimeFrom(),
            'work_time_to' => Variables::getWorkTimeTo(),
            'work_days' => Variables::getWorkingDays(),
        ];
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

        $locale = Lang::getLocale();
        $translation = isset($this->pickerLang[$locale]) ? $this->pickerLang[$locale] : null;
        if ($translation !== null) {
            $this->addJs(self::PATH_PICKADATE_COMPRESSED.'translations/'.$translation.'.js');
        }

        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/convert.js');
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/reservationform.js');
    }

    /**
     * @return ReservationsFacade
     */
    protected function getFacade()
    {
        return App::make(ReservationsFacade::class);
    }
}
