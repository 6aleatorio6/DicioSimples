<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordFlexion extends Model
{
    protected $fillable = [
        'word_id',
        'form',
        'type',
        'modo',
        'tense',
        'person',
        'isPlural',
        'gender'
    ];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
