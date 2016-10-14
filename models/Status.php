<?php namespace VojtaSvoboda\Reservations\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete as SoftDeletingTrait;
use October\Rain\Database\Traits\Sortable as SortableTrait;
use October\Rain\Database\Traits\Validation as ValidationTrait;

/**
 * Status class.
 *
 * @package VojtaSvoboda\Reservations\Models
 */
class Status extends Model
{
    use SoftDeletingTrait;

    use SortableTrait;

    use ValidationTrait;

    /** @var string $table The database table used by the model */
    public $table = 'vojtasvoboda_reservations_statuses';

    /** @var array Rules */
    public $rules = [
        'name' => 'required|max:255',
        'ident' => 'required|unique:vojtasvoboda_reservations_statuses',
        'color' => 'max:7',
        'enabled' => 'boolean',
    ];

    /** @var array $dates */
    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    /** @var array Relations */
    public $belongsTo = [
        'reservations' => ['VojtaSvoboda\Reservations\Models\Reservation'],
    ];

    /**
     * Is enabled scope for filering only enabled statuses.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
