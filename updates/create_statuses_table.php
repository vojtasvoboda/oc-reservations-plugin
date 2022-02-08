<?php namespace VojtaSvoboda\Reservations\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('vojtasvoboda_reservations_statuses', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name', 300);
            $table->string('ident', 300);
            $table->char('color', 7)->nullable();
            $table->boolean('enabled')->default(true);
            $table->smallInteger('sort_order')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vojtasvoboda_reservations_statuses');
    }
}
