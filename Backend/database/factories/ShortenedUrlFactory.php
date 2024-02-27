<?php

namespace Database\Factories;

use App\Models\ShortenedUrl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShortenedUrlFactory extends Factory
{
    protected $model = ShortenedUrl::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url,
            'hash' => Str::random(6),
            // 'sub_id' => SubDirectories::factory(),
        ];
    }
}
