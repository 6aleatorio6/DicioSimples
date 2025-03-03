<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidWordException;
use App\Models\Word;
use App\Services\WordContentGeneratorService;
use App\Services\WordSuggestionService;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Contracts\Cache\Repository as Cache;


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

            $wordContent = $this->word->updateOrCreate(['word' => $wordName], $wordContentGenereated);

            $wordContent->createAndAttachWords("Antonyms", $wordContentGenereated['antonyms']);
            $wordContent->createAndAttachWords("Synonyms", $wordContentGenereated['synonyms']);
            $wordContent->baseForm()->associate($this->word->firstOrcreate(['word' => $wordContentGenereated['wordBase']]));

            $wordContent->load(['baseForm:id,word', 'wordSynonyms:id,word', 'wordAntonyms:id,word']);
        }


        return $wordContent;
    }


    public function __invoke(string $word)
    {
        // Validate word
        if (!$this->cache->has('word_' . $word)) {
            $suggestions = $this->wordSuggestionService->getSuggestionsCached($word);
            if ($suggestions) throw new InvalidWordException($word, $suggestions);
        }

        $wordContent = $this->cache->rememberForever(
            'word_' . $word,
            fn() => $this->getWordContent($word)
        );

        return Inertia::render('public/WordContent', $wordContent);
    }
}
