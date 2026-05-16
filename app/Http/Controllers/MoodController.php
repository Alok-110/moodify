<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoodController extends Controller
{
    public function index(Request $request)
    {
        $moodSlug = $request->get('mood', 'happy');

        $mood = DB::table('moods')->where('slug', $moodSlug)->first();

        if (!$mood) {
            return redirect('/dashboard');
        }

        $songs = DB::table('songs')
            ->join('mood_song', 'songs.id', '=', 'mood_song.song_id')
            ->join('moods', 'mood_song.mood_id', '=', 'moods.id')
            ->leftJoin('genres', 'songs.genre_id', '=', 'genres.id')
            ->where('moods.slug', $moodSlug)
            ->select('songs.*', 'genres.name as genre_name', 'genres.color as genre_color')
            ->inRandomOrder()
            ->paginate(20);

        $allMoods = DB::table('moods')->get();

        return view('mood', compact('mood', 'songs', 'allMoods'));
    }
}