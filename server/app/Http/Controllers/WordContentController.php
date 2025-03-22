<?php

namespace App\Http\Controllers;

use App\Adapters\WordContentLLMAdapter;
use App\Adapters\WordSuggestionAdapter;
use App\Exceptions\InvalidWordException;
use App\Models\Word;
use Inertia\Inertia;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;

class WordContentController extends Controller
{
    function __construct(
        private WordContentLLMAdapter $wordContentLLMAdapter,
        private WordSuggestionAdapter $wordSuggestionAdapter,
        private Word $word,
        private Cache $cache
    ) {}




    private function getWordContent(string $wordName)
    {
        $wordContent = $this->word->with(['baseForm:id,word', 'wordSynonyms:id,word', 'wordAntonyms:id,word'])
            ->where('word', '=', $wordName)
            ->whereNotNull('meanings')
            ->first();


        if (!$wordContent) {
            $wordContentGenereated = $this->wordContentLLMAdapter->generate($wordName);

            if (!$wordContentGenereated['isExist']) throw new InvalidWordException($wordName, []);

            $wordContent = $this->word->updateOrCreate(['word' => $wordName], $wordContentGenereated);

            $wordContent->createAndAttachWords("Antonyms", $wordContentGenereated['antonyms']);
            $wordContent->createAndAttachWords("Synonyms", $wordContentGenereated['synonyms']);
            $wordContent->baseForm()->associate($this->word->firstOrcreate(['word' => $wordContentGenereated['wordBase']]));

            $wordContent->load(['baseForm:id,word', 'wordSynonyms:id,word', 'wordAntonyms:id,word']);
        }


        return $wordContent;
    }


    private function inclementViewCount(string $wordName, string $ipAddress)
    {
        $cacheKey = 'word_' . $wordName . '_viewed_by_' . $ipAddress;

        if (!$this->cache->has($cacheKey)) {
            $this->word->where('word', $wordName)->increment('views');
            $this->cache->put($cacheKey, true, 3600); // Cache for 1 hour
        }
    }

    public function __invoke(string $wordName, Request $request)
    {
        // Validate word
        if (!$this->cache->has('word_' . $wordName)) {
            $suggestions = $this->wordSuggestionAdapter->getSuggestionsCached($wordName);
            if ($suggestions) throw new InvalidWordException($wordName, $suggestions);
        }

        $wordContent = $this->cache->rememberForever(
            'word_' . $wordName,
            fn() => $this->getWordContent($wordName)
        );

        $this->inclementViewCount($wordName, $request->ip());

        return Inertia::render('public/WordContent', $wordContent);
    }
}
