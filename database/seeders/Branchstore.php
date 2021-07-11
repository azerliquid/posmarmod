<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class Branchstore extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i<2; $i++) { 
            DB::table('branchstore')->insert([
                'branch_name' => $faker->name(),
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'id_headoffice' => $i + 10,
                'id_cashier' => $i + 11,
                'id_chef' => $i + 12,
            ]);
        }
    }
}
