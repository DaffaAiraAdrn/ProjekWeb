<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('abstract')->nullable();
            $table->longText('introduction')->nullable();
            $table->longText('methodology')->nullable();
            $table->longText('results')->nullable();
            $table->longText('conclusion')->nullable();
            $table->longText('references')->nullable();
            $table->json('attachments')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
