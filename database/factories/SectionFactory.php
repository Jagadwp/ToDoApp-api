<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dt = $this->faker->dateTimeBetween('now', '+15 days');
        $date = $dt->format("Y-m-d");
        $day = Carbon::createFromFormat('Y-m-d', $date)->format('l');

        return [
            'name' => $this->faker->sentence(3),
            'date' => $date,
            'day' => $day,
            'user_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
