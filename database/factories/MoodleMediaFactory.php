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
            'title' => ["english"=> "en-title","french" =>"fr-titre"],
            'description' => ["english"=> "en-description","french" =>"fr-description"],
            'media' => $this->faker->image(),
            'keywords' => ["english"=> "en-keyword","french" =>"fr-mots-cles"],
            'license_id' => MoodleMediaLicense::factory()->create()->id,
        ];
    }
}
