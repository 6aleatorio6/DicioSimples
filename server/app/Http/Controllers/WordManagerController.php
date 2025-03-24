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

        $words = $this->word->with(['baseForm:id,word', 'wordSynonyms:id,word', 'wordAntonyms:id,word'])->orderBy("views", "desc")->whereNotNull('meanings')->where("word", "LIKE", "{$query}%")->paginate(8, '*',);

        return Inertia::render('Dashboard/Dashboard', [
            'tableWords' =>  $words,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->word->destroy($id);

        return back()->with('status', 'Word deleted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
}
