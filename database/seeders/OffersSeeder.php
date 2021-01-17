<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {          
        DB::table('offers')->insert([
            'type' => 0,
            'product_id' => 4,
            'from_product_quantity' => 1,
            'to_product_id' => 0,
            'to_product_quantity' => 0,
            'discounts' => 10,
            'start_date' => '2021-01-17',
            'end_date' => '2021-03-30',
         ]);
         DB::table('offers')->insert([
            'type' => 1,
            'product_id' => 1,
            'from_product_quantity' => 2,
            'to_product_id' => 3,
            'to_product_quantity' => 1,
            'discounts' => 50,
            'start_date' => '2021-01-17',
            'end_date' => '2021-03-30',
         ]);
        
    }
}
