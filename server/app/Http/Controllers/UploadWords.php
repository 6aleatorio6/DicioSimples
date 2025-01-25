<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;


class UploadWords extends Controller
{
    public function __invoke(Request $request, Word $word)
    {
        $request->validate(['file' => 'required|file|mimes:txt,csv']);

        $pathFile = $request->file('file')->getRealPath();
        $lines = file($pathFile);


        $wordsArray = [];

        foreach ($lines as  $line) {
            $wordsArray[] = ["name" => trim($line)];

            if (count($wordsArray) < 5000) continue;

            $word->insertOrIgnore($wordsArray);
            $wordsArray = [];
        }

        $word->insertOrIgnore($wordsArray);


        return back();
    }
}
