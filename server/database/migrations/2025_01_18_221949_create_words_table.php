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
            $table->string('name')->unique();
            $table->string('summary')->nullable();
            $table->string('examples')->nullable();
            $table->integer('views')->default(0);
        });

        Schema::create('word_synonym', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained(); # ->cascadeOnDelete(); Deus me livre o efeito em cadeia que pode acontecer
            $table->foreignId('synonym_id')->constrained('words'); # ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('word_antonym', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained(); #->cascadeOnDelete();
            $table->foreignId('antonym_id')->constrained('words'); #->cascadeOnDelete();
            $table->timestamps();
        });




        // Tabela de flexões de verbos
        Schema::create('word_flexion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained()->onDelete('cascade');

            $table->string('form'); // A forma flexionada da palavra 

            // 
            $table->string('type')->nullable();
            $table->string('mood')->nullable();
            $table->string('tense')->nullable();
            $table->integer('person')->nullable();   // ex.: 1, 2 ou 3 (representa a pessoa)
            $table->boolean('is_plural')->nullable();
            $table->string('gender')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_flexion');
        Schema::dropIfExists('word_synonym');
        Schema::dropIfExists('word_antonym');
        Schema::dropIfExists('words');
    }
};
