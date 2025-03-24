<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as alterações para adicionar o cascade.
     */
    public function up(): void
    {
        // Tabela words: modifica a foreign key do campo base_form.
        Schema::table('words', function (Blueprint $table) {
            $table->dropForeign(['base_form']);
            $table->foreign('base_form')
                ->references('id')
                ->on('words')
                ->onDelete('set null');
        });

        // Tabela word_synonym: modifica as foreign keys.
        Schema::table('word_synonym', function (Blueprint $table) {
            $table->dropForeign(['word_id']);
            $table->dropForeign(['synonym_id']);
            $table->foreign('word_id')
                ->references('id')
                ->on('words')
                ->onDelete('cascade');
            $table->foreign('synonym_id')
                ->references('id')
                ->on('words')
                ->onDelete('cascade');
        });

        // Tabela word_antonym: modifica as foreign keys.
        Schema::table('word_antonym', function (Blueprint $table) {
            $table->dropForeign(['word_id']);
            $table->dropForeign(['antonym_id']);
            $table->foreign('word_id')
                ->references('id')
                ->on('words')
                ->onDelete('cascade');
            $table->foreign('antonym_id')
                ->references('id')
                ->on('words')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverte as alterações realizadas.
     */
    public function down(): void
    {
        // Reverte as alterações na tabela word_antonym.
        Schema::table('word_antonym', function (Blueprint $table) {
            $table->dropForeign(['word_id']);
            $table->dropForeign(['antonym_id']);
            // Aqui, recriamos com a regra original ou sem cascade
            $table->foreign('word_id')
                ->references('id')
                ->on('words')
                ->onDelete('restrict');
            $table->foreign('antonym_id')
                ->references('id')
                ->on('words')
                ->onDelete('restrict');
        });

        // Reverte as alterações na tabela word_synonym.
        Schema::table('word_synonym', function (Blueprint $table) {
            $table->dropForeign(['word_id']);
            $table->dropForeign(['synonym_id']);
            $table->foreign('word_id')
                ->references('id')
                ->on('words')
                ->onDelete('restrict');
            $table->foreign('synonym_id')
                ->references('id')
                ->on('words')
                ->onDelete('restrict');
        });

        // Reverte a alteração na tabela words para o campo base_form.
        Schema::table('words', function (Blueprint $table) {
            $table->dropForeign(['base_form']);
            $table->foreign('base_form')
                ->references('id')
                ->on('words')
                ->onDelete('set null');
        });
    }
};
