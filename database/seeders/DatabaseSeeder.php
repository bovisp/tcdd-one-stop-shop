<?php

namespace Database\Seeders;

use App\Models\Support\Language;
use App\Models\Support\Quarter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        $languages = [
            ['name' => 'English'],
            ['name' => 'French'],
        ];

        $quarters = [
            ['name' => 'Q1'],
            ['name' => 'Q2'],
            ['name' => 'Q3'],
            ['name' => 'Q4'],
        ];

        foreach ($languages as $language) {
            Language::query()->create($language);
        }

        foreach ($quarters as $quarter) {
            Quarter::query()->create($quarter);
        }
    }
}
