<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\MoodleCourseCatalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoodleCourseCatalogueFactory extends Factory
{
    protected $model = MoodleCourseCatalogue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'language' => 'French',
            'publish_date' => $this->faker->date,
            'title' => $this->faker->text(5),
            'completion_time' => $this->faker->numberBetween(1,4),
            'objective' => 'test',
            'category_id' => CourseCategory::factory()->create()->id,

        ];
    }
}
