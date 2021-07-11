<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EmployeSeeder extends Seeder
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
            DB::table('employe')->insert([
                'name' => $faker->name(),
                'nip' =>  $faker->randomNumber($nbDigits = NULL, $strict = false),
                'phone' => $faker->phoneNumber,
                'role' => $faker->randomElement($array = array ('Kasir','Dapur','Kepala Toko')),
                'id_branch' => $faker->numberBetween(1,4),
            ]);
        }
    }
}
