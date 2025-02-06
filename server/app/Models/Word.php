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
        'examples',
        'conjugations'
    ];

    protected $guarded = ['views'];

    public function synonyms()
    {
        return $this->belongsToMany(Word::class, 'word_synonym', 'word_id', 'synonym_id');
    }

    public function antonyms()
    {
        return $this->belongsToMany(Word::class, 'word_antonym', 'word_id', 'antonym_id');
    }


    public function conjugations()
    {
        return $this->hasMany(WordFlexion::class);
    }
}
