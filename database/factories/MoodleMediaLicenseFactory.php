<?php

namespace Database\Factories;

use App\Models\MoodleMediaLicense;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoodleMediaLicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = MoodleMediaLicense::class;

    public function definition()
    {
        return [
            'name' => ["english"=> "en-name","french" =>"fr-nom"],
            'description' => ["english"=> "en-description","french" =>"fr-description"],
        ];
    }
}
