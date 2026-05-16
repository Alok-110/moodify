<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'mood_song');
    }
}
