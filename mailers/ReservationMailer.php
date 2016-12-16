<?php namespace VojtaSvoboda\Reservations\Mailers;

use App;
use Mail;
use Request;
use VojtaSvoboda\Reservations\Models\Reservation;

class ReservationMailer extends BaseMailer
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
        $recipients = $this->initRecipients();
        $recipients['email'] = $reservation->email;
        $recipients['name'] = trim($reservation->name . ' ' . $reservation->lastname);

        $template = $this->getTemplateIdent('reservation');

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
