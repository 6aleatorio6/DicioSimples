<?php

namespace App\Http\Controllers;

use App\Adapters\WordSuggestionAdapter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WordSearchController extends Controller
{
    function __construct(private WordSuggestionAdapter $wordSuggestionAdapter,) {}

    public function show()
    {
        return Inertia::render('public/WordSearch');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => ['required', 'string', 'max:46', 'min:2', 'regex:/^[a-zA-ZÀ-ú]+$/'],
        ]);

        $query = $request->input('query');

        $suggestions = $this->wordSuggestionAdapter->getSuggestionsCached($query);


        return Inertia::render(
            'public/WordSearch',
            [
                "suggestions" => $suggestions ?? [$query],
            ]
        );
    }
}
