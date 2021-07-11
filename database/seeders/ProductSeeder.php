<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i<50; $i++) { 
            DB::table('products')->insert([
                'code_products' =>  "Kode ". $i,
                'name_products' => $faker->name(),
                'id_categorys' => $faker->numberBetween(1,4),
                'id_units' => $faker->numberBetween(1,4),
                'price' => $faker->numberBetween(10000,50000)
            ]);
        }
    }
}
