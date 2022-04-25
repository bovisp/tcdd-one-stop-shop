<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExternalCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'view_lesson' => $this->faker->text('20'),
            'completion_lesson' => $this->faker->text('20'),
            'view_language' => $this->faker->randomElement(['English', 'French']),
            'completion_language' => $this->faker->randomElement(['English', 'French']),
            'view_session' => $this->faker->randomElement(['1', '2','3','4','5']),
            'view_date' => $this->faker->date('Y-m-d'),
            'date_completed' => $this->faker->date('Y-m-d'),
        ];
    }
}
