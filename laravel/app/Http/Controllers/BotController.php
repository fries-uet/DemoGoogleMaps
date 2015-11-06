<?php

namespace App\Http\Controllers;

use App\Helpers\FriesChat;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Bot;

class BotController extends Controller {

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

		return view( 'bot-setup' )->with( 'bots', $arr_bots )
		                          ->with( 'bot_id', $bot_id )
		                          ->with( 'updated', $updated );
	}

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

		return view( 'bot-setup' )->with( 'bots', $arr_bots )
		                          ->with( 'bot_id', $bot_id )
		                          ->with( 'updated', $updated );
	}


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
}
