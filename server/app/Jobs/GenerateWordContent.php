<?php

namespace App\Jobs;

use App\Adapters\WordContentLLMAdapter;
use App\Data\WordLLMData;
use App\Exceptions\InvalidWordException;
use App\Models\Word;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateWordContent implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Word $wordModel) {}

    /**
     * Execute the job.
     */
    public function handle(WordContentLLMAdapter $LLMAdapter): void
    {
        $wordContentGenereated = $LLMAdapter->generate($this->wordModel->word);

        if (!$wordContentGenereated['isExist']) {
            $this->wordModel->update(['status' => 'UNKNOWN']);
            $this->fail(new InvalidWordException($this->wordModel->word, []));
        }

        dd($wordContentGenereated);

        $wordContentDTO = WordLLMData::validateAndCreate($wordContentGenereated);
    }
}
