<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'mood_id', 'is_auto', 'cover_color'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }

    public function songs()
{
    return $this->belongsToMany(Song::class, 'playlist_song', 'playlist_id', 'song_id')
                ->withPivot('order')
                ->withTimestamps();
}
}