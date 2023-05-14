<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\interfaces\MovieInterface;
use App\Models\Movie;

/**
 * Movies interface for repositories to implement
 */
class MovieRepository extends BaseRepository implements MovieInterface
{
    public function __construct(Movie $movie)
    {
        parent::__construct($movie);
    }

}