<?php

namespace App\Exceptions;

use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;

class InvalidWordException extends Exception
{
    public function __construct(private string $word, private array $suggestions) {}

    public function report()
    {
        Log::info('Tentativa de gerar uma palavra inválida.', ['word' => $this->word]);
    }

    public function render($request)
    {
        return Inertia::render('public/WordInvalid', [
            'word' => $this->word,
            'suggestions' => $this->suggestions
        ])->toResponse($request)->setStatusCode(400);
    }
}
