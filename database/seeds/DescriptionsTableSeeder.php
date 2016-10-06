<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DescriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker::create();
		
    	foreach (range(1,50) as $index) {
			$now = date('Y-m-d H:i:s', strtotime('now'));
	        DB::table('descriptions')->insert([
	            'author' => $faker->name,
				'title' => $faker->sentence,
	            'description' => $faker->text,
				'hamburger_id' => $faker->numberBetween(1,10),
				'created_at' => $now,
				'updated_at' => $now
	        ]);
        }
    }
}
