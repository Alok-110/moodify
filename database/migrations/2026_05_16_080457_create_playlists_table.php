<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('playlists', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('mood_id')->nullable()->constrained()->nullOnDelete();
        $table->boolean('is_auto')->default(false);
        $table->string('cover_color')->default('from-purple-400 to-purple-600');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlists');
    }
};
