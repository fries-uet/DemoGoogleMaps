<?php

namespace App\Http\Controllers;

use App\Helpers\FriesChat;
use App\Question;
use Illuminate\Http\Request;

class PageController extends Controller {
	/**
	 * Homepage
	 *
	 * @return \Illuminate\View\View
	 */
	public function home() {
		return view( 'home' );
	}

	public function bot() {
		$questions = Question::getAll();

		$arrTemp = [ ];
		for ( $i = count( $questions ) - 1; $i >= 0; $i -- ) {
			$arrTemp[] = $questions[ $i ];
		}

		return view( 'bot.bot' )->with( 'questions', $arrTemp );
	}

	public function botChatAPI( Request $request ) {
		onlyAllowPostRequest( $request );

		$question = $request->input( 'question' );
		$bot      = new FriesChat( $question );

		if ( $bot->getStatus() ) {
			Question::store( $bot->getQuestion(), $bot->getAnswer() );
		}

		return response()->json( [
			'status'   => 'OK',
			'question' => $bot->getQuestion(),
			'answer'   => $bot->getAnswer(),
		] );
	}

	public function botChat() {
		$bot = new FriesChat();

		return view( 'bot.chat' )->with( 'api', [
			$bot->getBotID(),
			route( 'bot.api' )
		] );
	}

	public function traffic() {

	}

	public function downloadBeta() {
		$app = url( '/' ) . '/download/maps-1.0.0.apk';

		return response()->redirectTo( $app );
	}
}
