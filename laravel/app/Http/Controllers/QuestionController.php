<?php

namespace App\Http\Controllers;

use App\Helpers\FriesChat;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends Controller {
	var $botid = '5639640be4b07d327ad88bed';
	var $token = '775ced42-8100-48ef-add1-a7cc6be261ab';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}

	public function getAnswer( Request $request ) {
		onlyAllowPostRequest( $request );

		$question = $request->input( 'question' );
		$chat_bot = new FriesChat( $question );
		if ( $chat_bot->getStatus() ) {
			Question::store( $chat_bot->getQuestion(), $chat_bot->getAnswer() );
		}

		return response()->json( $chat_bot->getOutput() );
	}

	public function getAllQuestion() {
		$questions = Question::getAll();

		return response()->json( [
			'status' => 'OK',
			'data'   => $questions,
		] );
	}

	public function webGetAll() {
		$questions = Question::getAll();

		return view( 'bot' )->with( 'questions', $questions );
	}
}
