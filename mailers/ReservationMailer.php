<?php namespace VojtaSvoboda\Reservations\Mailers;

use App;
use Mail;
use Request;
use VojtaSvoboda\Reservations\Models\Reservation;

class ReservationMailer
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
        $locale = App::getLocale();
        $appUrl = Request::url();
        $recipients['email'] = $reservation->email;
        $recipients['name'] = trim($reservation->name . ' ' . $reservation->lastname);

        $template = self::getTemplateIdent();

        $templateParameters = [
            'site' => $appUrl,
            'reservation' => $reservation,
            'locale' => $locale,
        ];

        Mail::send($template, $templateParameters, function($message) use ($recipients)
        {
            $message->to($recipients['email'], $recipients['name']);

            if (isset($recipients['bcc_email'], $recipients['bcc_name'])) {
                $message->bcc($recipients['bcc_email'], $recipients['bcc_name']);
            }
        });
    }

    /**
     * Get template ident by locale.
     *
     * @return string
     */
    private static function getTemplateIdent()
    {
        $locale = App::getLocale();
        $identBase = 'vojtasvoboda.reservations::mail.reservation-';
        $ident = $identBase . $locale;

        if (file_exists(__DIR__ . '/../views/mail/' . $ident . '.htm')) {
            return $ident;
        }

        return $identBase . self::DEFAULT_TEMPLATE_LOCALE;
    }
}
