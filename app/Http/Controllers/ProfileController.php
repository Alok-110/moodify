<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\PlayHistory;
use App\Models\Playlist;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $totalPlayed    = PlayHistory::where('user_id', $user->id)->count();
        $playlistCount  = Playlist::where('user_id', $user->id)->count();
        $memberSince    = $user->created_at->format('F Y');

        $topMood = PlayHistory::where('play_history.user_id', $user->id)
            ->join('mood_song', 'play_history.song_id', '=', 'mood_song.song_id')
            ->join('moods', 'mood_song.mood_id', '=', 'moods.id')
            ->selectRaw('moods.name, count(*) as cnt')
            ->groupBy('moods.name')
            ->orderByDesc('cnt')
            ->value('name');

        return view('profile', compact('user', 'totalPlayed', 'playlistCount', 'memberSince', 'topMood'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profile updated!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated!');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password' => 'required']);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        Auth::logout();
        $user->delete();

        return redirect('/');
    }
}