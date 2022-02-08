<?php namespace VojtaSvoboda\ReservationsUnits\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateStatusesSortOrderColumn extends Migration
{
    public function up()
    {
        $type = Schema::getColumnType('vojtasvoboda_reservations_statuses', 'sort_order');

        if ($type === 'boolean') {
            Schema::table('vojtasvoboda_reservations_statuses', function (Blueprint $table) {
                $table->smallInteger('sort_order')->change();
            });
        }
    }

    public function down()
    {
        // no need to convert column back to the boolean, it will works also with smallInteger
    }
}
