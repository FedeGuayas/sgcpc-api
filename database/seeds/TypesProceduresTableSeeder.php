<?php

use Illuminate\Database\Seeder;

class TypesProceduresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_procedures')->insert([
            'name'=>'infima',
            'status'=>\App\TypeProcedure::ENABLED
        ]);
        DB::table('type_procedures')->insert([
            'name'=>'subasta inversa',
            'status'=>\App\TypeProcedure::ENABLED
        ]);
        DB::table('type_procedures')->insert([
            'name'=>'menor cuantia',
            'status'=>\App\TypeProcedure::ENABLED
        ]);
        DB::table('type_procedures')->insert([
            'name'=>'licitación',
            'status'=>\App\TypeProcedure::ENABLED
        ]);
        DB::table('type_procedures')->insert([
            'name'=>'catálogo',
            'status'=>\App\TypeProcedure::ENABLED
        ]);
    }
}
