<?php namespace VojtaSvoboda\Reservations\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Carbon\Carbon;
use DB;
use Exception;
use October\Rain\Exception\ApplicationException;
use VojtaSvoboda\Reservations\Models\Reservation;

/**
 * Reservations report widget.
 *
 * @package VojtaSvoboda\Reservations\ReportWidgets
 */
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

    /**
     * Render widget.
     *
     * @return mixed
     */
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

    /**
     * Load data for widget. Data are dependent on 'days' widget property.
     *
     * @return array
     */
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
        $all = $this->sortItemsToDays($items);

        // we need at least two days, to display chart
        if (sizeof($all) == 1) {
            $day = reset($all);
            $date = Carbon::createFromFormat('Y-m-d', $day['date'])->subDays(1);
            $dateFormated = $date->format('Y-m-d');
            $all[$dateFormated] = [
                'timestamp' => $date->timestamp * 1000,
                'date' => $dateFormated,
                'count' => 0,
            ];
        }

        // count all
        $all_render = [];
        foreach ($all as $a) {
            $all_render[] = [$a['timestamp'], $a['count']];
        }

        return $all_render;
    }

    /**
     * Sort items by days.
     *
     * @param $items
     *
     * @return array
     */
    private function sortItemsToDays($items)
    {
        $all = [];

        foreach ($items as $item)
        {
            // date
            $timestamp = strtotime($item->created_at) * 1000;
            $day = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d');

            // init empty day
            if (!isset($all[$day])) {
                $all[$day] = [
                    'timestamp' => $timestamp,
                    'date' => $day,
                    'count' => 0,
                ];
            }

            // increase count
            $all[$day]['count']++;
        }

        return $all;
    }
}
