<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $user_id = 1;
        
        for ($i = 1; $i <= 50 ; $i++) { 
            $dt = $faker->dateTimeBetween('now', '+15 days');
            $date = $dt->format("Y-m-d");
            $day = Carbon::createFromFormat('Y-m-d', $date)->format('l');

            Section::create([
                'name' => $faker->sentence(3),
                'date' => $date,
                'day' => $day,
                'user_id' => $user_id 
            ]);

            
            if ($i % 10 == 0) {
                $user_id++;
            }
        }
        
    }
}
