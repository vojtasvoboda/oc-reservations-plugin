<?php namespace VojtaSvoboda\Reservations\Controllers;

use App;
use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Status;

class Reservations extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ImportExportController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    private $stateColors;
    private $stateNames;

    public $requiredPermissions = [
        'vojtasvoboda.reservations.reservations',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('VojtaSvoboda.Reservations', 'reservations', $this->action == 'export' ? 'export' : 'reservations');
    }

    public function index()
    {
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/bulk-actions.js');

        $this->asExtension('ListController')->index();
    }

    /**
     * Override displaying reservation status.
     *
     * @param $record
     * @param $columnName
     * @param null $definition
     *
     * @return string
     */
    public function listOverrideColumnValue($record, $columnName, $definition = null)
    {
        $statusStyle = "display:inline-block;width:13px;height:14px;position:relative;top:2px;margin-right:4px;color:#fff;font-size:11px;padding-left:3px;";

        if ($columnName == 'status_id') {
            $color = $this->getStateColor($record->status_id);
            $name = $this->getStateName($record->status_id);

            return '<div><span style="' . $statusStyle . 'background-color:' . $color . '"></span> ' . $name . '</div>';
        }
    }

    /**
     * Bulk actions
     *
     * @return mixed
     */
    public function index_onBulkAction()
    {
        if (($bulkAction = post('action')) && ($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds))
        {
            /** @var ReservationsFacade $facade */
            $facade = App::make('reservations');

            if ($bulkAction == 'delete') {
                $facade->bulkDelete($checkedIds);
            } else {
                $facade->bulkStateChange($checkedIds, $bulkAction);
            }
        }

        Flash::success('Reservation states has been successfully changed.');

        return $this->listRefresh();
    }

    /**
     * Get color by state ident.
     *
     * @param $ident
     *
     * @return null
     */
    private function getStateColor($ident)
    {
        if ($this->stateColors === null) {
            $this->stateColors = Status::lists('color', 'ident');
        }

        return isset($this->stateColors[$ident]) ? $this->stateColors[$ident] : null;
    }

    /**
     * Get name by state ident.
     *
     * @param $ident
     *
     * @return null
     */
    private function getStateName($ident)
    {
        if ($this->stateNames === null) {
            $this->stateNames = Status::lists('name', 'ident');
        }

        return isset($this->stateNames[$ident]) ? $this->stateNames[$ident] : null;
    }
}
