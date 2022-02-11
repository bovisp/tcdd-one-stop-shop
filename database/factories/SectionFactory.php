<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /** @var string */
    protected $model = Section::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
