<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // auteur
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title_fr');
            $table->string('title_en');
            $table->string('slug_fr')->unique();
            $table->string('slug_en')->unique();
            $table->longText('content_fr');
            $table->longText('content_en');
            $table->string('status')->default('brouillon');
            $table->date('published_at')->nullable();
            $table->string('seo_title_fr')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->text('meta_desc_fr')->nullable();
            $table->text('meta_desc_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};