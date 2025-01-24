<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{

    protected $fillable = [
        'name',
        'summary',
        'synonyms',
        'antonyms',
        'examples'
    ];

    protected $guarded = ['views'];
}
