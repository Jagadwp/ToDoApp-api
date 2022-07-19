<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Checklist;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $section_id = 1;
        
        for ($i = 1; $i <= 250 ; $i++) { 
            $status = $faker->randomElement(['Not started', 'In progress', 'Completed', 'On hold']);
            $hour = ($i % 10) + 1;
            $timeStart = date('H:i:s', 7200 * ($hour + 2));
            $timeEnd = date('H:i:s', strtotime($timeStart) + 3600);

            Checklist::create([
                'task' => $faker->sentence(3),
                'priority' => $faker->randomElement(['High', 'Medium', 'Low']),
                'status' => $status,
                'done' => $status == 'Completed' ? 1 : 0,
                'time_start' => $timeStart,
                'time_end' => $timeEnd,
                'section_id' => $section_id 
            ]);

            
            if ($i % 5 == 0) {
                $section_id++;
            }
        }
    }
}
