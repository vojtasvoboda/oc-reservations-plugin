<?php namespace VojtaSvoboda\Reservations\Mailers;

use App;
use Mail;
use Request;
use VojtaSvoboda\Reservations\Models\Reservation;
use VojtaSvoboda\Reservations\Models\Settings;

class ReservationAdminMailer extends BaseMailer
{
    /**
     * Send reservation confirmation mail.
     *
     * @param Reservation $reservation
     * @param int $reservationsCount
     */
    public function send(Reservation $reservation, $reservationsCount = 0)
    {
        // init
        $locale = App::getLocale();
        $appUrl = App::make('url')->to('/');
        $enabled = Settings::get('admin_confirmation_enable');
        $templateLocale = Settings::get('admin_confirmation_locale');
        $recipients = $this->initRecipients();
        $recipients['email'] = Settings::get('admin_confirmation_email');
        $recipients['name'] = Settings::get('admin_confirmation_name');

        // skip if disabled or empty email
        if (!$enabled || empty($recipients['email'])) {
            return;
        }

        $template = $this->getTemplateIdent('reservation-admin', $templateLocale);

        $templateParameters = [
            'site' => $appUrl,
            'reservation' => $reservation,
            'locale' => $locale,
            'reservationsCount' => $reservationsCount,
        ];

        if (App::environment() === 'testing') {
            return;
        }

        Mail::send($template, $templateParameters, function($message) use ($recipients)
        {
            $message->to($recipients['email'], $recipients['name']);

            if (!empty($recipients['bcc_email']) && !empty($recipients['bcc_name'])) {
                $message->bcc($recipients['bcc_email'], $recipients['bcc_name']);
            }
        });
    }
}
