<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Pop',       'slug' => 'pop',       'color' => '#f59e0b'],
            ['name' => 'Hip Hop',   'slug' => 'hiphop',    'color' => '#8b5cf6'],
            ['name' => 'Lo-fi',     'slug' => 'lofi',      'color' => '#14b8a6'],
            ['name' => 'Rock',      'slug' => 'rock',      'color' => '#ef4444'],
            ['name' => 'Ambient',   'slug' => 'ambient',   'color' => '#3b82f6'],
            ['name' => 'Indie',     'slug' => 'indie',     'color' => '#f97316'],
            ['name' => 'Classical', 'slug' => 'classical', 'color' => '#ec4899'],
            ['name' => 'Jazz',      'slug' => 'jazz',      'color' => '#10b981'],
        ];

        foreach ($genres as $genre) {
            DB::table('genres')->insertOrIgnore([
                ...$genre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}