<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     * we expose title, description, thumb, genres
     * as they are the only fields we need to create a movie
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'Description',
        'thumb',
        'genre',
        'popularity',
    ];

   /**
     * The attributes that should be guarded.
     * we guard id and is_active
     *
     * @var array<string, string>
     */
    protected $guarded = [
        'id',
        'is_active',
    ];
}
