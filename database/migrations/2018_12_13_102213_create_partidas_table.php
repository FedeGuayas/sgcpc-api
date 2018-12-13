<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidas', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('program_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->char('programa',3); // code programs = Esigef -> programa
            $table->char('actividad',3); // code activities = Esigef -> actividad
            $table->char('renglon',6); // code items = Esigef -> renglon
            $table->decimal('presupuesto',12,2)->unsigned()->nullable()->default(0);
            $table->decimal('disponible',12,2)->unsigned()->nullable()->default(0);
            $table->string('origen');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('item_id')->references('id')->on('items');

            $table->unique(['program_id','activity_id','item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partidas');
    }
}
