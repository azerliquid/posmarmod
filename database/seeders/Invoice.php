<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Faker\Factory as Faker;
use Carbon\Carbon;

class Invoice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        
        $faker = Faker::create('id_ID');
        $product = Product::all()->pluck('price','id_product');
        
        $id_product = [
            225,
            226,
            227,
            229,
            230,
            245,
            246,
            251,
            252,
            256,
            257,
            258,
            265,
            266,
            267
            ];
        $price =  [
            8000,
            12000,
            8000,
            13000,
            17000,
            20000,
            25000,
            30000,
            35000,
            8000,
            9000,
            17000,
            13000,
            10000,
            11000
        ];
        $date = Carbon::now()->subDays(4);

        $invoice=832;
        for ($i=1; $i<23; $i++) { 
            DB::table('invoice')->insert([
                'invoice' =>  "INV21070950". $i,
                'queue' => $i,
                'id_cashier' => 12,
                'id_branch' => 50,
                'cash_return' => $return = $faker->numberBetween(1000, 10000),
                'pay' => $pay = $faker->numberBetween(30000,120000),
                'cash' => $pay - $return,
                'status' => 1,
                'created_at' => $date
            ]);
            
            $item = $faker->randomElement($array = array (1,2,3));
            
            $invoice = $invoice+1;
            
            for ($j=1; $j <= $item ; $j++) {
                $index = $faker->randomElement($array = array (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14));

                DB::table('shopping')->insert([
                    'id_branch' => 50,
                    'id_invoice' => $invoice,
                    'id_product' => $id_product[$index],
                    'qty' => $qty = $faker->randomElement($array = array (1,2,3)),
                    'price' => $price[$index],
                    'totals' => $price[$index] * $qty,
                    'status' => 1,
                    'served' => 1000 * $faker->numberBetween(380,700),
                    'created_at' => $date

                ]);
            }

        }
    }
}
