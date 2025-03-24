<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidWordException;
use App\Models\Word;
use App\Services\WordContentGeneratorService;
use App\Services\WordSuggestionService;
use Inertia\Inertia;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;

class WordContentController extends Controller
{
    function __construct(
        private WordContentGeneratorService $wordMeaningGeneratorService,
        private WordSuggestionService $wordSuggestionService,
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
            $wordContentGenereated = $this->wordMeaningGeneratorService->generate($wordName);

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
        // Validate word with regex
        if (!preg_match('/^[\p{L}\p{M}\s\-]+$/u', $wordName)) {
            throw new InvalidWordException($wordName, []);
        }

        if (!$this->cache->has('word_' . $wordName)) {
            $suggestions = $this->wordSuggestionService->getSuggestionsCached($wordName);
            if ($suggestions) throw new InvalidWordException($wordName, $suggestions);
        }

        $wordContent = $this->cache->remember(
            'word_' . $wordName,
            now()->addDay(7),
            fn() => $this->getWordContent($wordName)
        );

        $this->inclementViewCount($wordName, $request->ip());

        return Inertia::render('public/WordContent', $wordContent);
    }
}
