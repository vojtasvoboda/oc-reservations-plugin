<?php namespace VojtaSvoboda\Reservations\Models;

use Config;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation as ValidationTrait;

class Settings extends Model
{
    use ValidationTrait;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'vojtasvoboda_reservations_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'returning_mark' => 'numeric'
    ];
}
