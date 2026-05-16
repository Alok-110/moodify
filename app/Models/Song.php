<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title', 'artist', 'album',
        'artwork_url', 'preview_url',
        'duration', 'genre_id'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function moods()
    {
        return $this->belongsToMany(Mood::class, 'mood_song');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')->withPivot('order');
    }
}