<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CourseCategory::class;

    public function definition()
    {
        return [
            'category_name' => ["english"=> "en","french" =>"fr"],
        ];
    }
}
