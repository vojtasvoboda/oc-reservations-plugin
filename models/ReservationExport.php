<?php namespace VojtaSvoboda\Reservations\Models;

use Backend\Facades\BackendAuth;
use Backend\Models\ExportModel;
use Config;

class ReservationExport extends ExportModel
{
    public $table = 'vojtasvoboda_reservations_reservations';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $belongsTo = [
        'status' => 'VojtaSvoboda\Reservations\Models\Status',
    ];

    public $fillable = [
        'status_enabled', 'status',
    ];

    public function exportData($columns, $sessionKey = null)
    {
        $query = Reservation::query();

        // filter by status
        if ($this->status_enabled) {
            $query->where('status_id', $this->status_id);
        }

        // prepare columns
        $reservations = $query->get();
        $reservations->each(function($item) use ($columns)
        {
            $item->addVisible($columns);
            $item->status_id = $item->status->name;
        });

        return $reservations->toArray();
    }

    public static function getStatusIdOptions()
    {
        return Status::orderBy('sort_order')->lists('name', 'id');
    }
}
