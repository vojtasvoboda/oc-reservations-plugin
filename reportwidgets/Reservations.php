<?php namespace VojtaSvoboda\Reservations\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Carbon\Carbon;
use DB;
use Exception;
use October\Rain\Exception\ApplicationException;
use VojtaSvoboda\Reservations\Models\Reservation;

class Reservations extends ReportWidgetBase
{
    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Reservations',
                'default' => 'Reservations',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'Widget title is required.',
            ],
            'days' => [
                'title' => 'Number of days',
                'default' => '30',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
            ],
        ];
    }

    public function render()
    {
        $error = false;
        $reservations = [];

        try {
            $reservations = $this->loadData();

        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }

        $this->vars['error'] = $error;
        $this->vars['reservations'] = $reservations;

        return $this->makePartial('widget');
    }

    protected function loadData()
    {
        $days = $this->property('days');
        if (!$days) {
            throw new ApplicationException('Invalid days value: ' . $days);
        }

        // get all reservations for gived days
        $interval = Carbon::now()->subDays($days)->toDateTimeString();
        $items = Reservation::where('created_at', '>=', $interval)->get();

        // parse data
        $all = [];
        foreach ($items as $item) {
            // date
            $timestamp = strtotime($item->created_at) * 1000;
            $day = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d');

            if (isset($all[$day])) {
                $all[$day][1]++;
            } else {
                $all[$day] = [$timestamp, 1];
            }
        }

        // count all
        $all_render = [];
        foreach ($all as $a) {
            $all_render[] = [$a[0], $a[1]];
        }

        return $all_render;
    }
}
