<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Dashboard extends Controller
{
    public function show(Request $request, Word $word)
    {

        $page = $request->query('p', 1);
        $query = $request->query('q', '');

        $words = $word->orderBy("views", "desc")->where("name", "LIKE", "{$query}%")->paginate(8, [
            "id",
            "name",
            "summary",
            "synonyms",
            "antonyms",
            "examples",
            "views",
        ], 'p', $page);

        return Inertia::render('Dashboard/Dashboard', [
            'tableWords' =>  $words,
        ]);
    }
}
