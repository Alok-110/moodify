<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $genres = DB::table('genres')->get();
        $moods  = DB::table('moods')->get();

        $query = DB::table('songs')
            ->leftJoin('genres', 'songs.genre_id', '=', 'genres.id')
            ->select('songs.*', 'genres.name as genre_name', 'genres.color as genre_color');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($q2) use ($q) {
                $q2->where('songs.title', 'like', "%{$q}%")
                   ->orWhere('songs.artist', 'like', "%{$q}%")
                   ->orWhere('songs.album', 'like', "%{$q}%");
            });
        }

        if ($request->filled('genre')) {
            $query->where('genres.slug', $request->genre);
        }

        if ($request->filled('mood')) {
            $query->join('mood_song', 'songs.id', '=', 'mood_song.song_id')
                  ->join('moods', 'mood_song.mood_id', '=', 'moods.id')
                  ->where('moods.slug', $request->mood);
        }

        $songs = $query->orderBy('songs.created_at', 'desc')->paginate(20);

        // AJAX request — return only the grid partial, not the full page
        if ($request->ajax || $request->get('ajax')) {
            $html = '';
            if ($songs->count()) {
                foreach ($songs as $song) {
                    $artworkUrl  = e($song->artwork_url ?? '');
                    $previewUrl  = e($song->preview_url ?? '');
                    $title       = e($song->title);
                    $titleJs     = addslashes($song->title);
                    $artistJs    = addslashes($song->artist);
                    $genreName   = e($song->genre_name ?? '');
                    $genreColor  = e($song->genre_color ?? '#7c3aed');
                    $id          = $song->id;

                    $artwork = $artworkUrl
                        ? "<img src=\"{$artworkUrl}\" alt=\"{$title}\" class=\"w-full h-full object-cover\">"
                        : '<div class="w-full h-full bg-gradient-to-br from-purple-400 to-indigo-600 flex items-center justify-center"><svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg></div>';

                    $genreBadge = $genreName
                        ? "<span class=\"inline-block mt-2 text-xs font-semibold px-2 py-0.5 rounded-full\" style=\"background:{$genreColor}18; color:{$genreColor}\">{$genreName}</span>"
                        : '';

                    $html .= "
                    <div class=\"song-card bg-white border border-gray-100 rounded-2xl p-3 hover:border-gray-200 hover:shadow-md transition cursor-pointer relative\"
                         onclick=\"playSong('{$previewUrl}', '{$titleJs}', '{$artistJs}', '{$artworkUrl}', {$id})\">
                        <div class=\"relative w-full aspect-square rounded-xl overflow-hidden mb-3 bg-gray-100\">
                            {$artwork}
                            <div class=\"play-btn absolute bottom-2 right-2\">
                                <div class=\"w-10 h-10 bg-purple-600 hover:bg-purple-700 rounded-full flex items-center justify-center shadow-lg\">
                                    <svg class=\"w-4 h-4 text-white ml-0.5\" fill=\"currentColor\" viewBox=\"0 0 24 24\"><path d=\"M8 5v14l11-7z\"/></svg>
                                </div>
                            </div>
                        </div>
                        <p class=\"text-sm font-bold text-gray-900 truncate\">{$title}</p>
                        <p class=\"text-xs text-gray-400 truncate mt-0.5\">" . e($song->artist) . "</p>
                        {$genreBadge}
                    </div>";
                }

                $grid = "<div data-count=\"{$songs->total()}\" class=\"grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-8\">{$html}</div>";
            } else {
                $grid = '
                <div data-count="0" class="text-center py-24">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <p class="text-gray-700 font-bold text-lg">No songs found</p>
                    <p class="text-sm text-gray-400 mt-1">Try a different search or clear the filters</p>
                    <button onclick="setFilter(\'mood\', \'\')" class="inline-block mt-4 text-sm text-purple-600 font-semibold hover:text-purple-700">Clear filters</button>
                </div>';
            }

            return response($grid);
        }

        return view('discover', compact('songs', 'genres', 'moods'));
    }
}