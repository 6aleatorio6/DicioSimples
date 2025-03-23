<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\InArray;
use Spatie\LaravelData\Data;

class WordLLMData extends Data
{
    public function __construct(
        public string $word,
        public string $partOfSpeech,
        public string $baseWord,
        #[InArray(['meanings.*.explanation' => 'required|string', 'meanings.*.title' => 'required|string'])]
        public array $meanings,
        #[ArrayType('string')]
        public array $synonyms,
        #[ArrayType('string')]
        public array $antonyms,
    ) {}
}
