<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WordManagerController extends Controller
{


    function __construct(
        private Word $word
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query('query', '');

        $words = $this->word->orderBy("views", "desc")->whereNotNull('meanings')->where("word", "LIKE", "{$query}%")->paginate(8, '*',);

        return Inertia::render('Dashboard/Dashboard', [
            'tableWords' =>  $words,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
}
