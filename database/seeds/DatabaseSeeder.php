<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');

        \App\User::truncate();
        \App\Area::truncate();
        \App\Department::truncate();
        \App\Worker::truncate();
        \App\Activity::truncate();
        \App\Program::truncate();
        \App\Item::truncate();
        \App\Partida::truncate();
        \Illuminate\Support\Facades\DB::table('activity_program')->truncate();

        \App\User::flushEventListeners(); //deshabilita los eventos del modelo usuario durante el seeder
        \App\Area::flushEventListeners();
        \App\Department::flushEventListeners();
        \App\Worker::flushEventListeners();
        \App\Activity::flushEventListeners();
        \App\Program::flushEventListeners();
        \App\Item::flushEventListeners();
        \App\Partida::flushEventListeners();
        
        $cantUsuarios=200;
        $cantArea=10;
        $cantDepartamentos=20;
        $cantWorker=80;
        $cantActividades=15;
        $cantProgramas=3;
        $cantItems=150;
        $cantPartidas=40;

        factory(\App\User::class, $cantUsuarios)->create();
        
        factory(\App\Area::class, $cantArea)->create();
        
        factory(\App\Department::class, $cantDepartamentos)->create();

        factory(\App\Worker::class, $cantWorker)->create();
        
        factory(\App\Activity::class, $cantActividades)->create();
        
        factory(\App\Program::class, $cantProgramas)->create()->each(
            function($programa){
                $actividades=\App\Activity::all()->random(mt_rand(1,10))->pluck('id');
                $programa->activities()->attach($actividades);
            }
        );
        
        factory(\App\Item::class, $cantItems)->create();

        factory(\App\Partida::class, $cantPartidas)->create();



    }
}
