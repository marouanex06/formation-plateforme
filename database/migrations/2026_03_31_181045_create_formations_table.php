<?php
// database/migrations/xxxx_create_formations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title_fr');
            $table->string('title_en');
            $table->string('slug_fr')->unique();
            $table->string('slug_en')->unique();
            $table->text('short_desc_fr')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->longText('full_desc_fr')->nullable();
            $table->longText('full_desc_en')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration')->nullable(); // durée en heures
            $table->string('level')->nullable();     // débutant, intermédiaire, etc.
            $table->string('status')->default('brouillon'); // Enum value
            $table->date('published_at')->nullable();
            // Champs SEO
            $table->string('seo_title_fr')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->text('meta_desc_fr')->nullable();
            $table->text('meta_desc_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};