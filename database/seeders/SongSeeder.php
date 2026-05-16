<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        // Search terms mapped to genre_id and mood_ids
        $searches = [
            ['term' => 'happy pop hits',      'genre_id' => 1, 'moods' => [1]],
            ['term' => 'sad emotional',        'genre_id' => 1, 'moods' => [2]],
            ['term' => 'workout energy',       'genre_id' => 2, 'moods' => [3]],
            ['term' => 'lofi chill study',     'genre_id' => 3, 'moods' => [4, 5]],
            ['term' => 'ambient focus',        'genre_id' => 5, 'moods' => [5]],
            ['term' => 'indie feel good',      'genre_id' => 6, 'moods' => [1, 4]],
            ['term' => 'hip hop',              'genre_id' => 2, 'moods' => [3]],
            ['term' => 'classical piano',      'genre_id' => 7, 'moods' => [5, 4]],
            ['term' => 'jazz relaxing',        'genre_id' => 8, 'moods' => [4]],
            ['term' => 'rock energetic',       'genre_id' => 4, 'moods' => [3]],
        ];

        foreach ($searches as $search) {
            $this->command->info("Fetching: {$search['term']}");

            try {
                $response = Http::timeout(10)->get('https://itunes.apple.com/search', [
                    'term'       => $search['term'],
                    'media'      => 'music',
                    'limit'      => 10,
                    'entity'     => 'song',
                ]);

                if (!$response->ok()) continue;

                $tracks = $response->json()['results'] ?? [];

                foreach ($tracks as $track) {
                    if (empty($track['previewUrl'])) continue;

                    // Insert song if not already exists
                    $exists = DB::table('songs')
                        ->where('title', $track['trackName'])
                        ->where('artist', $track['artistName'])
                        ->exists();

                    if (!$exists) {
                        $songId = DB::table('songs')->insertGetId([
                            'title'       => $track['trackName'],
                            'artist'      => $track['artistName'],
                            'album'       => $track['collectionName'] ?? null,
                            'artwork_url' => str_replace('100x100', '300x300', $track['artworkUrl100'] ?? ''),
                            'preview_url' => $track['previewUrl'],
                            'duration'    => isset($track['trackTimeMillis'])
                                                ? intval($track['trackTimeMillis'] / 1000)
                                                : 30,
                            'genre_id'    => $search['genre_id'],
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ]);

                        // Attach moods
                        foreach ($search['moods'] as $moodId) {
                            DB::table('mood_song')->insertOrIgnore([
                                'mood_id'    => $moodId,
                                'song_id'    => $songId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }

                // Small delay to be nice to iTunes API
                sleep(1);

            } catch (\Exception $e) {
                $this->command->warn("Failed: {$search['term']} — {$e->getMessage()}");
                continue;
            }
        }

        $count = DB::table('songs')->count();
        $this->command->info("Done! {$count} songs seeded.");
    }
}