<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\interfaces\MovieInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function getFavoriteMovies(int $userId) : LengthAwarePaginator
    {
        return $this->model->find($userId)->getFavoriteMovies()->paginate($this->perPage);
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
        return $this->model->find($userId)->getFavoriteMovies()->detach($movieId) ? true : false;
    }

}