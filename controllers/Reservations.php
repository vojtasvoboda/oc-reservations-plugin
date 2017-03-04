<?php namespace VojtaSvoboda\Reservations\Controllers;

use App;
use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Lang;
use VojtaSvoboda\Reservations\Facades\ReservationsFacade;
use VojtaSvoboda\Reservations\Models\Reservation;
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

        $action = $this->action == 'export' ? 'export' : 'reservations';
        BackendMenu::setContext('VojtaSvoboda.Reservations', 'reservations', $action);
    }

    /**
     * Extend controller listing.
     */
    public function index()
    {
        $this->addJs('/plugins/vojtasvoboda/reservations/assets/js/bulk-actions.js');
        $this->asExtension('ListController')->index();
    }

    /**
     * Override displaying reservation listing.
     *
     * @param Reservation $record
     * @param string $columnName
     *
     * @return string
     */
    public function listOverrideColumnValue($record, $columnName)
    {
        $statusStyle = "display:inline-block;width:13px;height:14px;position:relative;top:2px;margin-right:4px;color:#fff;font-size:11px;padding-left:3px;";

        if ($columnName == 'status_id') {
            $color = $this->getStateColor($record->status_id);
            $name = $this->getStateName($record->status_id);

            return '<div><span style="' . $statusStyle . 'background-color:' . $color . '"></span> ' . $name . '</div>';
        }

        if ($columnName == 'returning') {
            return $this->isReturning($record->email) ? '<i class=" icon-star"></i>' : '';
        }
    }

    /**
     * Bulk change state and bulk delete.
     *
     * @return mixed
     */
    public function index_onBulkAction()
    {
        if (($bulkAction = post('action')) && ($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            if ($bulkAction == 'delete') {
                $this->getFacade()->bulkDelete($checkedIds);
            } else {
                $this->getFacade()->bulkStateChange($checkedIds, $bulkAction);
            }

            $msg = Lang::get('vojtasvoboda.reservations::lang.reservations.change_status_success');
            Flash::success($msg);
        }

        return $this->listRefresh();
    }

    /**
     * Return if User is returning.
     *
     * @param string $email Users email.
     *
     * @return bool
     */
    private function isReturning($email)
    {
        return $this->getFacade()->isUserReturning($email);
    }

    /**
     * Get facade providing all plugin logic.
     *
     * @return ReservationsFacade
     */
    private function getFacade()
    {
        return App::make(ReservationsFacade::class);
    }

    /**
     * Get color by state ident.
     *
     * @param string $ident
     *
     * @return string|null
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
     * @param string $ident
     *
     * @return string|null
     */
    private function getStateName($ident)
    {
        if ($this->stateNames === null) {
            $this->stateNames = Status::lists('name', 'ident');
        }

        return isset($this->stateNames[$ident]) ? $this->stateNames[$ident] : null;
    }
}
