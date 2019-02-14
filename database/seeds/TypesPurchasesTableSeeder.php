<?php

use Illuminate\Database\Seeder;

class TypesPurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_purchases')->insert([
            'name'=>'bien',
            'status'=>\App\TypePurchase::ENABLED
        ]);
        DB::table('type_purchases')->insert([
            'name'=>'servicio',
            'status'=>\App\TypePurchase::ENABLED
        ]);
    }
}
