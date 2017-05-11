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
use Config;
use VojtaSvoboda\Reservations\Models\Settings;

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
        $dateFormat = Settings::get('formats_date', Config::get('vojtasvoboda.reservations::config.formats.date', 'd/m/Y'));
        $timeFormat = Settings::get('formats_time', Config::get('vojtasvoboda.reservations::config.formats.time', 'H:i'));
        $reservationInterval = Settings::get('reservation_interval', Config::get('vojtasvoboda.reservations::config.reservation.interval', 15));
        $defaultWorkingDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

        return [
            'formats_date' => $dateFormat,
            'formats_time' => $timeFormat,
            'reservation_interval' => (int) $reservationInterval,
            'first_weekday' => (int) Settings::get('first_weekday', false),
            'work_time_from' => Settings::get('work_time_from', '10:00'),
            'work_time_to' => Settings::get('work_time_to', '18:00'),
            'work_days' => Settings::get('work_days', $defaultWorkingDays),
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
