<?php namespace VojtaSvoboda\Reservations\Mailers;

use App;
use Config;
use Mail;
use Request;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Settings;

class ReservationAdminMailer
{
    /** Default template locale. */
    const DEFAULT_TEMPLATE_LOCALE = 'en';

    /**
     * Send reservation confirmation mail.
     *
     * @param Reservation $reservation
     */
    public static function send(Reservation $reservation)
    {
        if (App::environment() !== 'production') {
            return;
        }

        // init
        $locale = App::getLocale();
        $appUrl = Request::url();
        $enabled = Settings::get('admin_confirmation_enable');
        $recipients['email'] = Settings::get('admin_confirmation_email');
        $recipients['name'] = Settings::get('admin_confirmation_name');
        $recipients['bcc_email'] = Config::get('vojtasvoboda.reservations::config.mail.bcc_email');
        $recipients['bcc_name'] = Config::get('vojtasvoboda.reservations::config.mail.bcc_name');

        // skip if disabled or empty email
        if (!$enabled || empty($recipients['email'])) {
            return;
        }

        $template = self::getTemplateIdent();

        $templateParameters = [
            'site' => $appUrl,
            'reservation' => $reservation,
            'locale' => $locale,
            'reservationsCount' => self::getReservationsCount($reservation->email),
        ];

        Mail::send($template, $templateParameters, function($message) use ($recipients)
        {
            $message->to($recipients['email'], $recipients['name']);

            if (!empty($recipients['bcc_email']) && !empty($recipients['bcc_name'])) {
                $message->bcc($recipients['bcc_email'], $recipients['bcc_name']);
            }
        });
    }

    /**
     * Get template ident by locale.
     *
     * @return string
     */
    public static function getTemplateIdent()
    {
        $locale = Settings::get('admin_confirmation_locale');
        $identBase = 'vojtasvoboda.reservations::mail.reservation-admin-';
        $ident = $identBase . $locale;

        if (file_exists(__DIR__ . '/../views/mail/' . $ident . '.htm')) {
            return $ident;
        }

        return $identBase . self::DEFAULT_TEMPLATE_LOCALE;
    }

    /**
     * Get reservations count.
     *
     * @param $email
     *
     * @return int
     */
    public static function getReservationsCount($email)
    {
        /** @var ReservationsFacade $facade */
        $facade = App::make('vojtasvoboda.reservations.facade');

        return $facade->getReservationsWithSameEmailCount($email);
    }
}
