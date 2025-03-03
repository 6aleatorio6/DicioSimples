<?php

namespace App\Services;

use PhpSpellcheck\Misspelling;
use PhpSpellcheck\Spellchecker\Hunspell;


class WordSuggestionService
{
    private $hunspell;

    // Construtor para inicializar o serviço
    public function __construct(private $language = 'pt_BR')
    {
        $this->hunspell = Hunspell::create();
    }


    private function getMisspelling(string $word): ?Misspelling
    {
        return  $this->hunspell->check($word, [$this->language])->current();
    }

    /**
     * Quando retorna null, significa que a palavra está correta
     * 
     * @return array<string>
     */
    public function getSuggestions(string $prefix, int $limit): ?array
    {
        $misspelling = $this->getMisspelling($prefix);
        if (!$misspelling) return null;

        // Filtrar sugestões que contém espaços
        $suggestions = array_filter($misspelling->getSuggestions(), fn($suggestion) => !strpos($suggestion, ' '));

        // Limitar o número de sugestões
        $suggestions = array_slice($suggestions, 0, $limit);

        return $suggestions;
    }

   
}
