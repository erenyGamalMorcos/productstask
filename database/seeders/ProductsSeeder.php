<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'T-shirt',
            'price' => 10.99
         ]);
         DB::table('products')->insert([
             'name' => 'Pants',
             'price' => 14.99
         ]);
         DB::table('products')->insert([
             'name' => 'Jacket',
             'price' => 19.99
         ]);
         DB::table('products')->insert([
             'name' => 'Shoes',
             'price' => 24.99
         ]);
    }
}
