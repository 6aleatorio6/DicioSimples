<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidWordException;
use App\Http\Requests\WordContentRequest;
use App\Jobs\GenerateWordContent;
use App\Models\Word;
use App\Services\WordContentGeneratorService;
use App\Services\WordSuggestionService;
use Inertia\Inertia;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class WordContentController extends Controller
{
    function __construct(
        private WordSuggestionService $wordSuggestionService,
        private Word $word,
        private Cache $cache
    ) {}


    private function incrementViewCount(string $wordName, string $ipAddress)
    {
        $cacheKey = 'word_' . $wordName . '_viewed_by_' . $ipAddress;

        if (!$this->cache->has($cacheKey)) {
            $this->word->where('word', $wordName)->increment('views');
            $this->cache->put($cacheKey, true, 3600); // Cache for 1 hour
        }
    }

    public function getWordContent(string $wordName)
    {
        $cacheKey = 'word_' . $wordName;

        $wordContentCached = $this->cache->get($cacheKey);
        $wordContent = $wordContentCached ?? $this->word->getWordFull($wordName);

        $validForCache = $wordContent && ($wordContent['meanings'] || !$wordContent['isExist']);
        if (!$wordContentCached && $validForCache) $this->cache->put($cacheKey, $wordContent, 3600 * 24 * 3); // Cache for 3 days


        if (!$wordContent) {
            $this->cache->remember(
                $cacheKey  . '_dispatch',
                3600 * 3, // Cache for 3 hours
                fn() => GenerateWordContent::dispatch($wordName) && true
            );
        }

        return $wordContent;
    }



    public function __invoke(string $wordName, Request $request)
    {
        $suggestions = $this->wordSuggestionService->getSuggestionsCached($wordName);
        if ($suggestions) throw new InvalidWordException($wordName, $suggestions);

        $wordContent = $this->getWordContent($wordName);
        if ($wordContent && !$wordContent['isExist']) throw new InvalidWordException($wordName, []);



        if (!$wordContent) {
            return Inertia::render('public/WordContentGenerate', [
                'word' => $wordName,
            ])->toResponse($request)->setStatusCode(202);
        }

        $this->incrementViewCount($wordName, $request->ip());
        return Inertia::render('public/WordContent', $wordContent);
    }
}
