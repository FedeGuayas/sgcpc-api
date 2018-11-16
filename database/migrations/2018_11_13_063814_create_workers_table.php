<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->unique();
            $table->integer('department_id')->unsigned();
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('email')->unique();
            $table->char('dni',10)->nullable()->unique(); //requerido sino esta el pasaporte
            $table->string('passport')->nullable()->unique();
            $table->string('position')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers');
    }
}
