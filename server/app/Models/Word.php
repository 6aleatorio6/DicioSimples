<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $word
 * @property string|null $part_of_speech
 * @property int|null $base_form
 * @property array<array-key, mixed>|null $meanings
 * @property int $view_count
 * @property WordStatus $status
 * @property-read Word|null $baseForm
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Word> $wordAntonyms
 * @property-read int|null $word_antonyms_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Word> $wordSynonyms
 * @property-read int|null $word_synonyms_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereBaseForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereMeanings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word wherePartOfSpeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereWord($value)
 * @property string|null $base_word
 * @property-read Word|null $baseWord
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereBaseWord($value)
 * @mixin \Eloquent
 */
class Word extends Model
{
	protected $table = 'words';

	protected $fillable = [
		'word',
		'part_of_speech',
		'base_word',
		'meanings',
		'status'
	];

	protected $casts = [
		'meanings' => 'array',
	];

	public function baseWord()
	{
		return $this->belongsTo(Word::class, 'base_word');
	}

	public function wordSynonyms()
	{
		return $this->belongsToMany(Word::class, 'word_synonym', 'word_id', 'synonym');
	}

	public function wordAntonyms()
	{
		return $this->belongsToMany(Word::class, 'word_antonym', 'word_id', 'antonym');
	}

	protected function setStatusAttribute(WordStatus $value)
	{
		$this->attributes['status'] = $value;
	}


	// query builder 

	public function findByNameWithRelations(string $wordName)
	{
		return Word::with(['baseForm:word', 'wordSynonyms:word', 'wordAntonyms:word'])
			->whereNotStatus(WordStatus::PARTIAL)
			->whereWord($wordName)
			->first();
	}
}

enum WordStatus: string
{
	case COMPLETED = 'COMPLETED';
	case PARTIAL = 'PARTIAL';
	case FAILED = 'FAILED';
	case UNKNOWN = 'UNKNOWN';
	case PROCESSING = 'PROCESSING';
}
