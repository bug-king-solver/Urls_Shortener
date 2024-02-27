<?php

namespace Database\Factories;

use App\Models\SubDirectories;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubDirectoriesFactory extends Factory
{
    protected $model = SubDirectories::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
