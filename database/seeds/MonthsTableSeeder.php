<?php

use Illuminate\Database\Seeder;

class MonthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months')->insert([
            'month'=>'enero',
            'cod'=>1
        ]);
        DB::table('months')->insert([
            'month'=>'febrero',
            'cod'=>2
        ]);
        DB::table('months')->insert([
            'month'=>'marzo',
            'cod'=>3
        ]);
        DB::table('months')->insert([
            'month'=>'abril',
            'cod'=>4
        ]);
        DB::table('months')->insert([
            'month'=>'mayo',
            'cod'=>5
        ]);
        DB::table('months')->insert([
            'month'=>'junio',
            'cod'=>6
        ]);
        DB::table('months')->insert([
            'month'=>'julio',
            'cod'=>7
        ]);
        DB::table('months')->insert([
            'month'=>'agosto',
            'cod'=>8
        ]);
        DB::table('months')->insert([
            'month'=>'septiembre',
            'cod'=>9
        ]);
        DB::table('months')->insert([
            'month'=>'octubre',
            'cod'=>10
        ]);
        DB::table('months')->insert([
            'month'=>'noviembre',
            'cod'=>11
        ]);
        DB::table('months')->insert([
            'month'=>'diciembre',
            'cod'=>12
        ]);
    }
}
