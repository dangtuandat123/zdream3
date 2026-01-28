<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generated_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('style_id')->constrained('styles');
            $table->text('final_prompt');
            $table->json('selected_options')->nullable();
            $table->text('user_custom_input')->nullable();
            $table->json('generation_params')->nullable();
            $table->decimal('estimated_cost', 10, 2)->default(0);
            $table->string('storage_path')->nullable();
            $table->string('provider_task_id')->nullable();
            $table->string('provider_polling_url')->nullable();
            $table->decimal('provider_cost', 10, 4)->nullable();
            $table->string('legacy_provider_task_id')->nullable();
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->text('error_message')->nullable();
            $table->decimal('credits_used', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_images');
    }
};
