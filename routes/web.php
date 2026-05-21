<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\PlaylistController;
use App\Models\PlayHistory;
use App\Models\Playlist;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('landing');
});

// Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();

    $recentSongs = PlayHistory::where('user_id', $user->id)
        ->with('song')
        ->latest('played_at')
        ->get()
        ->unique('song_id')
        ->take(8)
        ->pluck('song');

    $totalPlayed       = PlayHistory::where('user_id', $user->id)->count();
    $playedThisWeek    = PlayHistory::where('user_id', $user->id)
                            ->where('played_at', '>=', now()->subDays(7))->count();
    $playlistCount     = Playlist::where('user_id', $user->id)->count();
    $moodPlaylistCount = Playlist::where('user_id', $user->id)->whereNotNull('mood_id')->count();

    $topMood = PlayHistory::where('play_history.user_id', $user->id)
        ->join('mood_song', 'play_history.song_id', '=', 'mood_song.song_id')
        ->join('moods', 'mood_song.mood_id', '=', 'moods.id')
        ->selectRaw('moods.name, count(*) as cnt')
        ->groupBy('moods.name')
        ->orderByDesc('cnt')
        ->value('name');

    return view('dashboard', compact(
        'recentSongs', 'totalPlayed', 'playedThisWeek',
        'playlistCount', 'moodPlaylistCount', 'topMood'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth middleware group
Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/discover', [DiscoverController::class, 'index']);

 
    Route::get('/playlists', [PlaylistController::class, 'index']);
    Route::post('/playlists', [PlaylistController::class, 'store']);
    Route::get('/playlists/list', function () {
        $playlists = Playlist::where('user_id', Auth::id())
            ->withCount('songs')
            ->latest()
            ->get(['id', 'name', 'cover_color', 'songs_count']);
        return response()->json($playlists);
    });
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show']);
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy']);
    Route::post('/playlists/{playlist}/songs', [PlaylistController::class, 'addSong']);
    Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong']);


    Route::post('/play/{song}', function (App\Models\Song $song) {
        PlayHistory::updateOrCreate(
            ['user_id' => Auth::id(), 'song_id' => $song->id],
            ['played_at' => now()]
        );
        return response()->json(['ok' => true]);
    });
    Route::get('/mood', [App\Http\Controllers\MoodController::class, 'index']);

});

require __DIR__.'/auth.php';