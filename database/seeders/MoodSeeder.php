<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        $moods = [
            ['name' => 'Happy',     'slug' => 'happy',     'color' => '#f59e0b'],
            ['name' => 'Sad',       'slug' => 'sad',       'color' => '#3b82f6'],
            ['name' => 'Energetic', 'slug' => 'energetic', 'color' => '#ef4444'],
            ['name' => 'Chill',     'slug' => 'chill',     'color' => '#14b8a6'],
            ['name' => 'Focused',   'slug' => 'focused',   'color' => '#8b5cf6'],
        ];

        foreach ($moods as $mood) {
            DB::table('moods')->insertOrIgnore([
                ...$mood,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}