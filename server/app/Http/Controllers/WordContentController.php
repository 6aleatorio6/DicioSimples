<?php

namespace App\Http\Controllers;

use App\Action\GetWordContentAction;
use App\Adapters\WordContentLLMAdapter;
use App\Adapters\WordSuggestionAdapter;
use App\Models\Word;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Repository as Cache;

class WordContentController extends Controller
{
    function __construct(
        private WordContentLLMAdapter $wordContentLLMAdapter,
        private WordSuggestionAdapter $wordSuggestionAdapter,
        private Word $word,
        private GetWordContentAction $getWordContentAction,
        public Cache $cache,
    ) {}




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
        $wordContent = $this->getWordContentAction->execute($wordName);

        if (!$wordContent) {
            // entrar pagina de espera, pq a palavra ainda não foi processada
        }

        $this->inclementViewCount($wordName, $request->ip());

        return Inertia::render('public/WordContent', $wordContent);
    }
}
