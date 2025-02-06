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
        Schema::create('search_words', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('query')->unique();
            $table->foreignId('word_id')->constrained(); #->cascadeOnDelete();
            $table->foreignId('flexion_id')->nullable()->constrained('word_conjugation'); #->cascadeOnDelete()
            $table->integer('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_words');
    }
};
