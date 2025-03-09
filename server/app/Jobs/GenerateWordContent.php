<?php

namespace App\Jobs;

use App\Exceptions\InvalidWordException;
use App\Models\Word;
use App\Services\GeminiWordGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GenerateWordContent implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $wordName
    ) {}

    /**
     * Execute the job.
     */
    public function handle(GeminiWordGenerationService $wordGenerateContent, Word $word): void
    {
        // gera 
        $wordContent = $wordGenerateContent->generate($this->wordName);

        if (!$wordContent['isExist']) {
            $word->insert(['word' => $this->wordName, 'isExist' => false]);
            return;
        }

        // válida
        $this->validateContentOrThrow($wordContent);

        // salva
        $word->createWord($wordContent);
    }

    private function validateContentOrThrow(array $WordContent): void
    {
        // 
        $wordRules =  ['required', 'string', 'max:46', 'min:2', 'regex:/^[\p{L}\s]+$/u'];
        $validator = Validator::make($WordContent, [
            'word' =>  $wordRules,
            'partOfSpeech' => ['required', 'string', 'max:255'],
            'wordBase' =>  $wordRules,
            'meanings' => ['required', 'array'],
            'meanings.*.explanation' => ['required', 'string'],
            'meanings.*.title' => ['required', 'string'],
            'antonyms' => ['array'],
            'antonyms.*' =>  $wordRules,
            'synonyms' => ['array'],
            'synonyms.*' =>  $wordRules,
        ]);


        if ($validator->fails()) throw new ValidationException($validator);
    }
}
