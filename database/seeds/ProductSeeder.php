<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Medicine($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Science($faker));

        foreach(range(500,1000) as $index) {
            DB::table('products')->insert([
            'drug_name' => $faker->medicine,
            'chemical_name' =>$faker->chemicalElementSymbol,
            'manufacturer_country' => $faker->country,
            'manufacturer_company' => $faker->company,
            'distribution_company' => $faker->company,
            'expire_date' => $faker->date($format = 'Y-m-d', $min = '+ 1years'),
            'original_price' => $faker->numberBetween($min = 1000, $max = 4000),
            'selling_price' => $faker->numberBetween($min = 4000, $max = 9000),
            'quantity' => $faker->numberBetween($min = 50, $max = 1000),
            'user_id' => $faker->numberBetween($min = 1, $max = 8),
            ]);
        }
    }
}
