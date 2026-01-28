<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail_url')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('provider_model_id');
            $table->string('legacy_provider_model_id')->nullable();
            $table->text('base_prompt')->nullable();
            $table->json('config_payload')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('allow_user_custom_prompt')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('capabilities')->nullable();
            $table->json('image_slots')->nullable();
            $table->json('system_images')->nullable();
            $table->foreignId('tag_id')->nullable()->constrained('tags')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('styles');
    }
};
