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

        // Schema::create('word_inflection', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('word_id')->constrained()->onDelete('cascade');
        //     $table->string('inflected_form'); // A forma inflexionada da palavra

        //     // Colunas enum para detalhar a flexão do verbo
        //     $table->enum('tense', ['present', 'past', 'future'])->nullable();
        //     $table->enum('mood', ['indicative', 'subjunctive', 'imperative'])->nullable();
        //     $table->enum('person', ['first', 'second', 'third'])->nullable();
        //     $table->enum('number', ['singular', 'plural'])->nullable();

        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_inflection');
        Schema::dropIfExists('word_synonym');
        Schema::dropIfExists('word_antonym');
        Schema::dropIfExists('words');
    }
};
