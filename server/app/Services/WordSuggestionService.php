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
     * @return array<string>
     */
    public function getSuggestions(string $prefix, int $limit): array
    {
        $misspelling = $this->getMisspelling($prefix);
        if (!$misspelling) return [$prefix];

        // Limitar o número de sugestões
        $suggestions = array_slice($misspelling->getSuggestions(), 0, $limit);

        // Filtrar sugestões que contém espaços
        $suggestions = array_filter($suggestions, function ($suggestion) {
            return strpos($suggestion, ' ') === false;
        });


        return $suggestions;
    }

    public function validateWord(string $word): bool
    {
        return !!$this->getMisspelling($word);
    }
}
