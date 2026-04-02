<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->string('duration', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->integer('duration')->nullable()->change();
        });
    }
};