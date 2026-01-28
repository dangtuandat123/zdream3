<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('style_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_id')->constrained('styles')->cascadeOnDelete();
            $table->string('label');
            $table->string('group_name');
            $table->string('prompt_fragment');
            $table->string('icon')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('style_options');
    }
};
