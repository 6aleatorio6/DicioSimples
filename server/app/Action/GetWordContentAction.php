<?php

namespace App\Action;

use App\Adapters\WordSuggestionAdapter;
use App\Data\WordLLMData;
use App\Exceptions\InvalidWordException;
use App\Models\Word;
use App\Models\WordStatus;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class GetWordContentAction
{

    public function __construct(
        public WordSuggestionAdapter $wordSuggestionAdapter,
        public Cache $cache,
        public Word $word
    ) {}


    private function handleStatus($wordContent)
    {
        switch ($wordContent->status) {

            case WordStatus::UNKNOWN:
                throw new InvalidWordException($wordContent->word, []);

            case WordStatus::FAILED:
                throw new InternalErrorException("Falha ao processar a palavra '{$wordContent->word}'.");

            case WordStatus::PROCESSING:
                Log::info("Palavra '{$wordContent->word}' está sendo processada.");
                return false;

            case WordStatus::COMPLETED:
                Log::info("Palavra '{$wordContent->word}' foi processada com sucesso.");
                return true;
        }
    }

    /**
     * Se o método não voltar nada, quer dizer que a palavra vai ser processada      
     */
    public function execute(string $wordName)
    {
        $cacheKey = 'word_' . $wordName;
        $cachedWord = $this->cache->get($cacheKey);

        if ($cachedWord) return WordLLMData::from($cachedWord);

        $wordContent = $this->word->findByNameWithRelations($wordName);

        $hasProcessed = $this->handleStatus($wordContent);

        if ($hasProcessed) return WordLLMData::from($wordContent);
    }
}
