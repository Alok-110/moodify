<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistController extends Controller
{
    // All playlists for the user
    public function index()
    {
        $playlists = Playlist::where('user_id', Auth::id())
            ->withCount('songs')
            ->latest()
            ->get();

        return view('playlists.index', compact('playlists'));
    }

    // Single playlist with its songs
    public function show(Playlist $playlist)
    {
        abort_if($playlist->user_id !== Auth::id(), 403);

        $songs = $playlist->songs()->get();

        return view('playlists.show', compact('playlist', 'songs'));
    }

    // Create playlist
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $colors = [
            'from-purple-400 to-purple-600',
            'from-pink-400 to-rose-500',
            'from-blue-400 to-indigo-600',
            'from-teal-400 to-teal-600',
            'from-orange-400 to-pink-500',
            'from-yellow-400 to-orange-500',
        ];

        Playlist::create([
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => Auth::id(),
            'cover_color' => $colors[array_rand($colors)],
        ]);

        return redirect('/playlists')->with('success', 'Playlist created!');
    }

    // Delete playlist
    public function destroy(Playlist $playlist)
    {
        abort_if($playlist->user_id !== Auth::id(), 403);
        $playlist->delete();
        return redirect('/playlists')->with('success', 'Playlist deleted.');
    }

    // Add song to playlist
    public function addSong(Request $request, Playlist $playlist)
    {
        abort_if($playlist->user_id !== Auth::id(), 403);

        $songId = $request->input('song_id');

        if (!$songId) {
            return response()->json(['ok' => false, 'error' => 'No song id'], 400);
        }

        $already = $playlist->songs()->wherePivot('song_id', $songId)->exists();

        if (!$already) {
            $playlist->songs()->attach($songId, ['order' => $playlist->songs()->count()]);
        }

        return response()->json(['ok' => true, 'already' => $already]);
    }
    // Remove song from playlist
    public function removeSong(Playlist $playlist, Song $song)
    {
        abort_if($playlist->user_id !== Auth::id(), 403);
        $playlist->songs()->detach($song->id);
        return back()->with('success', 'Song removed.');
    }
}
