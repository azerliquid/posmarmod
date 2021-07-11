<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class Outcome extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i<5; $i++) { 
            DB::table('outcome')->insert([
                'name' => $faker->name(),
                'cashier_name' => $faker->name(),
                'price' => $price = $faker->numberBetween(10000,50000),
                'qty' => $qty = $faker->numberBetween(1,8),
                'outcome' => $faker->numberBetween(100000,250000),
            ]);
        }
    }
}
