<?php

namespace App\Http\Controllers;

use App\Services\WordSuggestionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WordSearchController extends Controller
{
    function __construct(private WordSuggestionService $wordSuggestionService) {}

    public function show()
    {
        return Inertia::render('public/WordSearch');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => ['required', 'string', 'max:46', 'min:3', 'regex:/^[a-zA-ZÀ-ú]+$/'],
        ]);

        $query = $request->input('query');
        $suggestions = $this->wordSuggestionService->getSuggestions($query, 5);


        return Inertia::render(
            'public/WordSearch',
            [
                "suggestions" => $suggestions,
                "hasSuggestions" => count($suggestions) > 0
            ]
        );
    }
}
