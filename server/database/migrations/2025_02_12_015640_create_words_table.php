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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('word')->unique();
            $table->string('partOfSpeech')->nullable();
            $table->foreignId('base_form')->nullable()->constrained('words');
            $table->json('meanings')->nullable();
            $table->integer('views')->default(0);
        });

        Schema::create('word_synonym', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained(); # ->cascadeOnDelete();
            $table->foreignId('synonym_id')->constrained('words'); # ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('word_antonym', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained(); #->cascadeOnDelete();
            $table->foreignId('antonym_id')->constrained('words'); #->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_synonym');
        Schema::dropIfExists('word_antonym');
        Schema::dropIfExists('words');
    }
};
