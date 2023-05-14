<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovieFactory extends Factory
{
    /**
     * Define the movies default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /* @var string */
        $genre = $this->faker->randomElement(['action', 'comedy', 'drama', 'horror', 'romance', 'sci-fi', 'thriller']);
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'thumb' => $this->faker->imageUrl(480, 680, $genre.' movie poster'),
            'genre' => $genre,
            'popularity' => $this->faker->numberBetween(1, 100),
            'is_active' => true,
            'created_at' => now(),
        ];
    }

}
