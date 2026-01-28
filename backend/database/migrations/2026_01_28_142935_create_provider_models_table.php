<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_models', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('model_slug');
            $table->string('endpoint');
            $table->string('category')->nullable();
            $table->json('capabilities')->nullable();
            $table->json('param_schema')->nullable();
            $table->json('limits')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('label')->nullable();
            $table->string('version')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_models');
    }
};
