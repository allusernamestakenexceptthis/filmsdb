<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UsersMoviesFavoritesRel extends Pivot
{
    public $timestamps = false;
}
