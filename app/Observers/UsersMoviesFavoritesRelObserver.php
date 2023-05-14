<?php

namespace App\Observers;

use App\Models\Movie;
use App\Models\UsersMoviesFavoritesRel;

class UsersMoviesFavoritesRelObserver
{
    /**
     * Handle the UsersMoviesFavoritesRel "created" event.
     */
    public function created(UsersMoviesFavoritesRel $usersMoviesFavoritesRel): void
    {
        if ($usersMoviesFavoritesRel->isDirty()) {
            Movie::find($usersMoviesFavoritesRel->movie_id)->increment('popularity');
        }
    }

    /**
     * Handle the UsersMoviesFavoritesRel "updated" event.
     */
    public function updated(UsersMoviesFavoritesRel $usersMoviesFavoritesRel): void
    {
        //
    }

    /**
     * Handle the UsersMoviesFavoritesRel "deleted" event.
     */
    public function deleted(UsersMoviesFavoritesRel $usersMoviesFavoritesRel): void
    {
        //neither wasChanged or IsDity works here
        Movie::find($usersMoviesFavoritesRel->movie_id)->decrement('popularity');
    }

    /**
     * Handle the UsersMoviesFavoritesRel "restored" event.
     */
    public function restored(UsersMoviesFavoritesRel $usersMoviesFavoritesRel): void
    {
        //
    }

    /**
     * Handle the UsersMoviesFavoritesRel "force deleted" event.
     */
    public function forceDeleted(UsersMoviesFavoritesRel $usersMoviesFavoritesRel): void
    {
        //
    }
}