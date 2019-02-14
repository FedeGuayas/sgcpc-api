<?php

/**
 * Tabla para almacenar la planificacion de cada partida presupuestaria, su distribucion por cada mes del año
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partida_id')->unsigned();
            $table->integer('area_id')->unsigned(); // area que se asigno el presupuesto
            $table->integer('area_comp')->unsigned()->default(0); // area con que se compartio el presupuesto
            $table->integer('month_id')->unsigned();
            $table->string('compartido')->default(\App\Process::PRESUPUESTO_NO_COMPARTIDO);
            $table->decimal('plan_inicial',12,2)->unsigned()->default(0); // permanece invariable
            $table->decimal('monto',12,2)->unsigned()->default(0);
            $table->decimal('comprometido',12,2)->unsigned()->default(0);
            $table->decimal('disponible',12,2)->unsigned()->default(0);
            $table->decimal('ejecutado',12,2)->unsigned()->default(0);
            $table->decimal('ahorrado',12,2)->unsigned()->default(0);

            $table->timestamps();

            $table->foreign('partida_id')->references('id')->on('partidas');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('month_id')->references('id')->on('months');

            $table->unique(['partida_id','area_id','month_id','area_comp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
}
