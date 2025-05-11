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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale'); // e.g., 'en', 'fr'
            $table->string('key'); // e.g., 'welcome_message'
            $table->text('content'); // translated text
            $table->json('tags')->nullable(); // e.g., ["mobile", "web"]
            $table->timestamps();

            $table->index(['locale', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
