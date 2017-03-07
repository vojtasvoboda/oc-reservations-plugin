<?php namespace VojtaSvoboda\Reservations\Mailers;

use App;
use Config;

class BaseMailer
{
    /** Default template locale. */
    const DEFAULT_TEMPLATE_LOCALE = 'en';

    /**
     * Get template ident by locale.
     *
     * @param string $name
     * @param string $locale
     *
     * @return string
     */
    public function getTemplateIdent($name, $locale = null)
    {
        if ($locale === null) {
            $locale = App::getLocale();
        }
        $identBase = 'vojtasvoboda.reservations::mail.' . $name . '-';

        if (file_exists(__DIR__ . '/../views/mail/' . $name . '-' . $locale . '.htm')) {
            return $identBase . $locale;
        }

        return $identBase . self::DEFAULT_TEMPLATE_LOCALE;
    }

    /**
     * Init recipients array.
     *
     * @return array
     */
    public function initRecipients()
    {
        $recipients = [];
        $recipients['bcc_email'] = Config::get('vojtasvoboda.reservations::config.mail.bcc_email');
        $recipients['bcc_name'] = Config::get('vojtasvoboda.reservations::config.mail.bcc_name');

        return $recipients;
    }
}
