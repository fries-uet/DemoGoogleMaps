<?php

namespace App\Http\Controllers;

use App\Helpers\FriesChat;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Bot;

class BotController extends Controller {
	/**
	 * List question & answer
	 *
	 * @return $this
	 */
	public function bot() {
		$questions = Question::getAll();

		$arrTemp = [ ];
		for ( $i = count( $questions ) - 1; $i >= 0; $i -- ) {
			$arrTemp[] = $questions[ $i ];
		}

		return view( 'bot.bot' )->with( 'questions', $arrTemp );
	}

	/**
	 * Get setup bot chat
	 *
	 * @return $this
	 */
	public function getSetup() {
		$updated = 'get';

		$fries_bot = new FriesChat();
		$fries_bot->getAPIBots();
		$arr_bots = $fries_bot->getBots();

		$bot_id = '';
		$bot    = Bot::all();
		if ( $bot->count() > 0 ) {
			$bot_id = $bot->first()->value( 'bot_id' );
		}

		return view( 'bot.setup' )->with( 'bots', $arr_bots )
		                          ->with( 'bot_id', $bot_id )
		                          ->with( 'updated', $updated );
	}

	/**
	 * Update setup bot chat
	 *
	 * @param Request $request
	 *
	 * @return $this
	 */
	public function postSetup( Request $request ) {
		$updated = 'success';
		$bot_id  = $request->input( 'bot_id' );

		$fries_bot = new FriesChat();
		$fries_bot->getAPIBots();
		$arr_bots = $fries_bot->getBots();

		$bot      = Bot::all();
		$bot_name = false;
		foreach ( $arr_bots as $b ) {
			if ( $b->id == $bot_id ) {
				$bot_name = $b->name;
			}
		}

		if ( $request->input( 'password' ) != 'uet' ) {
			$updated = 'error';
		} else {
			if ( $bot_name != false ) {
				if ( $bot->count() > 0 ) {
					$bot_id_old = $bot->first()->value( 'bot_id' );
					Bot::where( 'bot_id', $bot_id_old )->update( [
						'bot_id' => $bot_id,
						'name'   => $bot_name,
					] );
				} else {
					$bot_c = Bot::create( [
						'bot_id' => $bot_id,
						'name'   => $bot_name,
					] );
				}
			}
		}

		return view( 'bot.setup' )->with( 'bots', $arr_bots )
		                          ->with( 'bot_id', $bot_id )
		                          ->with( 'updated', $updated );
	}

	/**
	 * Bot chat API
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
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

	/**
	 * Bot chat demo
	 *
	 * @return $this
	 */
	public function botChat() {
		$bot = new FriesChat();

		return view( 'bot.chat' )->with( 'api', [
			$bot->getBotID(),
			route( 'bot.api' )
		] );
	}
}
