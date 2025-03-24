<?php

namespace App\Services;

use PhpSpellcheck\Misspelling;
use PhpSpellcheck\Spellchecker\Hunspell;
use Illuminate\Contracts\Cache\Repository as Cache;


class WordSuggestionService
{
    private $hunspell;

    // Construtor para inicializar o serviço
    public function __construct(private Cache $cache)
    {
        $this->hunspell = Hunspell::create();
    }


    private function getMisspelling(string $word): ?Misspelling
    {
        return  $this->hunspell->check($word, ["pt_BR"])->current();
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

    public function getSuggestionsCached(string $prefix, $limit = 5): ?array
    {
        return $this->cache->remember(
            'search_suggestions_' . $prefix . '_' . $limit,
            now()->addDay(7),
            fn() => $this->getSuggestions($prefix, $limit)
        );
    }
}
