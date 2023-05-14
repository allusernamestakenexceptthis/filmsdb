<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\interfaces\MovieInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Movies interface for repositories to implement
 */
class UserRepository extends BaseRepository implements MovieInterface
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Get User By Email
     * 
     * @param string $email
     * 
     * @return User|bool
     */
    public function getUserByEmail(string $email) : User
    {
        return $this->model->where('email', $email)->first() ?? false;
    }

    /**
     * Get User Favorite Movies
     *
     * @param integer $userId
     * @return LengthAwarePaginator
     */
    public function getFavoriteMovies(int $userId, array $searchQueryArray = []) : LengthAwarePaginator
    {
        $query = $this->model->find($userId)->getFavoriteMovies()->getQuery();

        // to enable search on favorite movies we need add fillables of movies
        //TODO: create a fillable for joined tables or add them automatically in base repository
        $this->setFillable(array_merge($this->model->getFillable(), (new Movie)->getFillable()));

        return $this->processQuery($query, $searchQueryArray);
    }

    /**
     * add Favorite Movie to User
     *
     * @param integer $userId
     * @param integer $movieId
     * @return boolean
     */
    public function addFavoriteMovie(int $userId, int $movieId) : bool
    {
        return $this->model->find($userId)->getFavoriteMovies()->attach($movieId) ?? false;
    }

    /**
     * remove Favorite Movie from User
     *
     * @param integer $userId
     * @param integer $movieId
     * @return boolean
     */
    public function removeFavoriteMovie(int $userId, int $movieId) : bool
    {

        $user = $this->model->find($userId);

        if (!$user) {
            return false;
        }
    
        $favoriteMovie = $user->getFavoriteMovies()->wherePivot('movie_id', $movieId)->first();
    
        if (!$favoriteMovie) {
            return false;
        }
        return $user->getFavoriteMovies()->detach($movieId) ? true : false;
    }

}