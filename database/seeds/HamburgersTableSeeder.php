<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class HamburgersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
		$faker = Faker::create();
		
    	foreach (range(1,10) as $index) {
			$now = date('Y-m-d H:i:s', strtotime('now'));
	        DB::table('hamburgers')->insert([
	            'name' => $faker->word . ' Burger',
	            'author' => $faker->name,
	            'overview' => $faker->paragraph,
				'created_at' => $now,
				'updated_at' => $now
	        ]);
        }
	
    }
}
