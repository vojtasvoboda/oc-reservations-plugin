<?php namespace VojtaSvoboda\Reservations\Models;

use App;
use Carbon\Carbon;
use Config;
use Model;
use October\Rain\Database\Traits\SoftDelete as SoftDeleteTrait;
use October\Rain\Database\Traits\Validation as ValidationTrait;
use October\Rain\Exception\ApplicationException;
use Request;
use Str;

/**
 * Reservation class.
 *
 * @package VojtaSvoboda\Reservations\Models
 */
class Reservation extends Model
{
    use SoftDeleteTrait;

    use ValidationTrait;

    /** @var string $table The database table used by the model */
    public $table = 'vojtasvoboda_reservations_reservations';

    /** @var array Rules */
    public $rules = [
        'date' => 'required|date|reservation',
        'locale' => 'max:20',
        'email' => 'required|email',
        'name' => 'required|max:300',
        'street' => 'max:300',
        'town' => 'max:300',
        'zip' => 'numeric|nullable',
        'phone' => 'required|max:300',
        'message' => 'required|max:3000',
    ];

    public $customMessages = [
        'reservation' => 'vojtasvoboda.reservations::lang.errors.already_booked',
    ];

    public $fillable = [
        'status', 'date', 'locale', 'email', 'name', 'lastname',
        'street', 'town', 'zip', 'phone', 'message',
    ];

    public $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    public $belongsTo = [
        'status' => 'VojtaSvoboda\Reservations\Models\Status',
    ];

    /**
     * Before create reservation.
     */
    public function beforeCreate()
    {
        $this->hash = $this->getUniqueHash();
        $this->number = $this->getUniqueNumber();

        $this->locale = App::getLocale();

        $this->ip = Request::server('REMOTE_ADDR');
        $this->ip_forwarded = Request::server('HTTP_X_FORWARDED_FOR');
        $this->user_agent = Request::server('HTTP_USER_AGENT');

        if ($this->status === null) {
            $this->status = $this->getDefaultStatus();
        }
    }

    /**
     * If reservation is cancelled.
     *
     * @param string $statusIdent
     *
     * @return bool
     */
    public function isCancelled($statusIdent = null)
    {
        if ($statusIdent === null) {
            $statusIdent = $this->status->ident;
        }
        $cancelledStatuses = Config::get('vojtasvoboda.reservations::config.statuses.cancelled', ['cancelled']);

        return in_array($statusIdent, $cancelledStatuses);
    }

    /**
     * Scope for getting non cancelled reservations.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotCancelled($query)
    {
        $cancelledStatuses = Config::get('vojtasvoboda.reservations::config.statuses.cancelled', ['cancelled']);

        return $query->whereHas('status', function($query) use ($cancelledStatuses) {
            $query->whereNotIn('ident', $cancelledStatuses);
        });
    }

    /**
     * Scope for getting current date reservations.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeCurrentDate($query)
    {
        return $query->where('date', '>', Carbon::now()->format('Y-m-d H:i:s'));
    }

    /**
     * Set machine scope
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeMachine($query)
    {
        $ip_addr = Request::server('REMOTE_ADDR');
        $ip_forwarded = Request::server('HTTP_X_FORWARDED_FOR');
        $user_agent = Request::server('HTTP_USER_AGENT');

        return $query->whereIp($ip_addr)->whereIpForwarded($ip_forwarded)->whereUserAgent($user_agent);
    }

    /**
     * Get default reservation status.
     *
     * @return Status
     */
    public function getDefaultStatus()
    {
        $statusIdent = Config::get('vojtasvoboda.reservations::config.statuses.received', 'received');

        return Status::where('ident', $statusIdent)->first();
    }

    /**
     * Generate unique hash for each reservation.
     *
     * @return string|null
     */
    public function getUniqueHash()
    {
        $length = Config::get('vojtasvoboda.reservations::config.hash', 32);
        if ($length == 0) {
            return null;
        }

        return substr(md5('reservations-' . Str::random($length)), 0, $length);
    }

    /**
     * Generate unique number for each reservation. With this hash you can reference
     * concrete reservation instead of using internal Reservation ID.
     *
     * @return string|null
     */
    public function getUniqueNumber()
    {
    	// init
        $min = Config::get('vojtasvoboda.reservations::config.number.min', 123456);
        $max = Config::get('vojtasvoboda.reservations::config.number.max', 999999);
        if ($min == 0 || $max == 0) {
            return null;
        }

        // generate random number
        $count = 0;
        do {
            $number = mt_rand($min, $max);

        } while ((self::where('number', $number)->count() > 0) && (++$count < 1000));

        return $count >= 1000 ? null : $number;
    }
}
