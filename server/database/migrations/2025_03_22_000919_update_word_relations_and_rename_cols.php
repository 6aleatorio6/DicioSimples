<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {


        Schema::table('words', function (Blueprint $table) {
            $table->renameColumn('partOfSpeech', 'part_of_speech');
            $table->renameColumn('views', 'view_count');
        });

        # Cria as novas relações
        Schema::table('word_synonym', function (Blueprint $table) {
            $table->string('synonym')->nullable();
            $table->foreign('synonym', 'synonym_word')->references('word')->on('words')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::table('word_antonym', function (Blueprint $table) {
            $table->string('antonym')->nullable();
            $table->foreign('antonym', 'antonym_word')->references('word')->on('words')->cascadeOnDelete()->cascadeOnUpdate();
        });


        # Passo 3: Preencher a nova coluna
        DB::table('word_synonym')
            ->orderBy('word_synonym.id')  // Ordena pela coluna 'id'
            ->join('words', 'word_synonym.synonym_id', '=', 'words.id') // Faz o join com a tabela 'words'
            ->chunk(200, function ($synonyms) {
                foreach ($synonyms as $synonym) {
                    DB::table('word_synonym')
                        ->where('synonym_id', $synonym->synonym_id)
                        ->update(['synonym' => $synonym->word]); // Atualiza diretamente com o valor do join
                }
            });


        DB::table('word_antonym')
            ->join('words', 'word_antonym.antonym_id', '=', 'words.id') // Faz o join com a tabela 'words'
            ->orderBy('word_antonym.id')  // Ordena pela coluna 'id'
            ->chunk(200, function ($antonyms) {
                foreach ($antonyms as $antonym) {
                    DB::table('word_antonym')
                        ->where('antonym_id', $antonym->antonym_id)
                        ->update(['antonym' => $antonym->word]); // Atualiza diretamente com o valor do join
                }
            });


        // Passo 3: Remover a chave estrangeira antiga (synonym_id e antonym_id)
        Schema::table('word_synonym', function (Blueprint $table) {
            $table->dropConstrainedForeignId('synonym_id');

            $table->string('synonym')->nullable(false)->change(); // Remove nullable
        });
        Schema::table('word_antonym', function (Blueprint $table) {
            $table->dropConstrainedForeignId('antonym_id');

            $table->string('antonym')->nullable(false)->change(); // Remove nullable
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Reverte o renome das colunas na tabela words
        Schema::table('words', function (Blueprint $table) {
            $table->renameColumn('part_of_speech', 'partOfSpeech');
            $table->renameColumn('view_count', 'views');
        });


        //
        Schema::table('word_synonym', function (Blueprint $table) {
            $table->foreignId('synonym_id')->nullable()->constrained('words')->cascadeOnDelete();
        });
        Schema::table('word_antonym', function (Blueprint $table) {
            $table->foreignId('antonym_id')->nullable()->constrained('words')->cascadeOnDelete();
        });

        //
        # Passo 3: Preencher a nova coluna
        DB::table('word_synonym')
            ->orderBy('word_synonym.id')  // Ordena pela coluna 'id'
            ->join('words', 'word_synonym.synonym', '=', 'words.word') // Faz o join com a tabela 'words'
            ->chunk(200, function ($synonyms) {
                foreach ($synonyms as $synonym) {
                    DB::table('word_synonym')
                        ->where('synonym', $synonym->synonym)
                        ->update(['synonym_id' => $synonym->id]); // Atualiza diretamente com o valor do join
                }
            });
        DB::table('word_antonym')
            ->join('words', 'word_antonym.antonym', '=', 'words.word') // Faz o join com a tabela 'words'
            ->orderBy('word_antonym.id')  // Ordena pela coluna 'id'
            ->chunk(200, function ($antonyms) {
                foreach ($antonyms as $antonym) {
                    DB::table('word_antonym')
                        ->where('antonym', $antonym->antonym)
                        ->update(['antonym_id' => $antonym->id]); // Atualiza diretamente com o valor do join
                }
            });

        // 
        Schema::table('word_synonym', function (Blueprint $table) {
            $table->dropForeign('synonym_word');
            $table->dropColumn('synonym');


            $table->integer('synonym_id')->nullable(false)->change(); // Remove nullable
        });
        Schema::table('word_antonym', function (Blueprint $table) {
            $table->dropForeign('antonym_word');
            $table->dropColumn('antonym');

            $table->integer('antonym_id')->nullable(false)->change(); // Remove nullable
        });
    }
};
