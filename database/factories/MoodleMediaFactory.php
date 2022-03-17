<?php

namespace Database\Factories;

use App\Models\MoodleMedia;
use App\Models\MoodleMediaLicense;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoodleMediaFactory extends Factory
{

    protected $model = MoodleMedia::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words($nb = 3, $asText = false),
            'description' => $this->faker->words($nb = 3, $asText = false),
            'media' => $this->faker->image(),
            'keywords' => $this->faker->words($nb = 3, $asText = false),
            'license_id' => MoodleMediaLicense::factory()->create()->id,
        ];
    }
}
