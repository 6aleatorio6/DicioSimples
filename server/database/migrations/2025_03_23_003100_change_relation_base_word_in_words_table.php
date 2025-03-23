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
        Schema::table('words', function (Blueprint $table) {
            $table->string('base_word')->nullable();
            $table->foreign('base_word', 'base_word_word')->references('word')->on('words')->cascadeOnDelete()->cascadeOnUpdate();
        });

        DB::table('words', 'w1')
            ->whereNotNull('w1.base_form') // Filtra palavras que possuem base_form
            ->join('words AS w2', 'w1.base_form', '=', 'w2.id') // Junta palavras pelo nome
            ->select('w1.id AS w1_id', 'w2.word AS base_word') // Seleciona o id da primeira tabela e o word da segunda tabela
            ->orderBy('w1_id') // Ordena pelo nome da palavra base
            ->chunk(200, function ($words) {
                foreach ($words as $word) {
                    DB::table('words')
                        ->where('id', $word->w1_id)
                        ->update(['base_word' => $word->base_word]); // Atualiza diretamente com o valor do join
                }
            });

        Schema::table('words', function (Blueprint $table) {
            $table->dropConstrainedForeignId('base_form');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->foreignId('base_form')->nullable()->constrained('words');
        });

        DB::table('words', 'w1')
            ->whereNotNull('w1.base_word') // Filtra palavras que possuem base_word
            ->join('words AS w2', 'w1.base_word', '=', 'w2.word') // Junta palavras pelo nome
            ->select(['w2.id as w2_id', 'w1.id as w1_id']) // Seleciona o id da primeira tabela e o id da segunda tabela
            ->orderBy('w1_id') // Ordena pelo nome da palavra base
            ->chunk(200, function ($words) {
                foreach ($words as $word) {
                    DB::table('words')
                        ->where('id', $word->w1_id)
                        ->update(['base_form' => $word->w2_id]); // Atualiza diretamente com o valor do join
                }
            });

        Schema::table('words', function (Blueprint $table) {
            $table->dropForeign('base_word_word');
            $table->dropColumn('base_word');
        });
    }
};
