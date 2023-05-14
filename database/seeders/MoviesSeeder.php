<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;

class MoviesSeeder extends Seeder
{
    /**
     * Seed movies tables with 50 random movies
     */
    public function run(): void
    {
        Movie::factory()->count(50)->create();
    }
}
