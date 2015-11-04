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
		try {

			$chat = Question::create( [
				'question' => $question,
				'answer'   => $answer,
			] );
		} catch ( \PDOException $exception ) {
			abort( 404, $exception->getMessage() );
		}
	}

	public static function getAll() {
		try {
			$questions = Question::all( [ 'question', 'answer' ] );

			return $questions;
		} catch ( \PDOException $exception ) {
			abort( 404, $exception->getMessage() );
		}

		return null;
	}
}
