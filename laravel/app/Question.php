<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
	protected $table = 'questions';

	protected $fillable
		= [
			'question',
			'answer',
		];

	public static function store( $question, $answer ) {
		$chat = Question::create( [
			'question' => $question,
			'answer'   => $answer,
		] );
	}
}
