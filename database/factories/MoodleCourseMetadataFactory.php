<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\MoodleCourseMetadata;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoodleCourseMetadataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = MoodleCourseMetadata::class;

    public function definition()
    {

        return [
            'course_id' => $this->faker->uuid(),
            'course_name_en' => $this->faker->text(),
            'course_name_fr' => $this->faker->text(),
            'publish_date' => $this->faker->date(),
            'description_en' => $this->faker->text(),
            'description_fr' => $this->faker->text(),
            'category_id' => CourseCategory::factory()->create()->id,
            'presenters' => $this->faker->text(),
            'keywords_en' => $this->faker->text(),
            'keywords_fr' => $this->faker->text(),
            'minimum_estimated_time' => rand(1,3),
            'maximum_estimated_time' => rand(1,3),
            'objectives_topics' => $this->faker->text(),
        ];

    }
}
