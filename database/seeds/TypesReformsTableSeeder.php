<?php

use Illuminate\Database\Seeder;

class TypesReformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_reforms')->insert([
            'name'=>'interna',
            'status'=>\App\TypeReform::ENABLED
        ]);
        DB::table('type_reforms')->insert([
            'name'=>'ministerial',
            'status'=>\App\TypeReform::ENABLED
        ]);
        DB::table('type_reforms')->insert([
            'name'=>'informativa',
            'status'=>\App\TypeReform::ENABLED
        ]);
    }
}
