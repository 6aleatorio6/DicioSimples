<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class Word extends Model
{
	protected $table = 'words';

	protected $casts = [
		'base_form' => 'int',
		'views' => 'int'
	];

	protected $fillable = [
		'word',
		'meanings',
	];

	protected $hidden = [
		'pivot',
		'created_at',
	];


	public function baseForm()
	{
		return $this->belongsTo(Word::class, 'base_form');
	}

	public function wordSynonyms()
	{
		return $this->belongsToMany(Word::class, 'word_synonym', 'word_id', 'synonym_id');
	}

	public function wordAntonyms()
	{
		return $this->belongsToMany(Word::class, 'word_antonym', 'word_id', 'antonym_id');
	}




	protected function setMeaningsAttribute($value)
	{
		$validator = Validator::make(['meanings' => $value], [
			'meanings' => 'array',
			'meanings.*.explanation' => 'required|string',
			'meanings.*.title' => 'required|string',
		]);

		if ($validator->fails())  new ValidationException($validator);

		$this->attributes['meanings'] = json_encode($value);
	}

	protected function getMeaningsAttribute($value)
	{
		return json_decode($value, true);
	}




	/** @param "Synonyms"|"Antonyms" $relation */
	public function createAndAttachWords(string $relation, array $wordNames)
	{
		// 1. Busca as palavras já existentes pelo nome
		$existingWords = self::select('word', 'id')->whereIn('word',  $wordNames)->get();

		// Pega os ids das palavras já existentes
		$idsToAttach = $existingWords->pluck('id')->toArray();

		// 2. Cria as palavras que não existem
		$wordsToCreate = array_diff($wordNames, $existingWords->pluck('word')->toArray());
		$wordsToCreate = array_map(fn($word)  => ['word' => $word], $wordsToCreate);

		if (count($wordsToCreate) == 0) return;

		self::insert($wordsToCreate, ['word']);

		// 3. Pega os IDs das novas palavras criadas e os adiciona aos IDs existentes
		$newIds = self::select('id')->whereIn('word', $wordsToCreate)->get()->pluck('id')->toArray();

		// Merge dos IDs existentes com os novos
		$idsToAttach = array_merge($idsToAttach, $newIds);

		// 4. Anexa os IDs na relação sem remover os já existentes
		$this->{'word' . $relation}()->attach($idsToAttach);
	}


	public function toArray()
	{
		$array = parent::toArray();

		// Converte as chaves para camelCase
		return collect($array)->mapWithKeys(function ($value, $key) {
			return [Str::camel($key) => $value];
		})->toArray();
	}
}
