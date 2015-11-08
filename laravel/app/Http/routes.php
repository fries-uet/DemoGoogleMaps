<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group( array( 'prefix' => 'v1' ), function () {
	/**
	 * API Location
	 */
	Route::group( array( 'prefix' => 'location' ), function () {
		// Get location by coordinates
		Route::get( 'byCoordinates/{lat},{lng}',
			'LocationController@byCoordinates' );

		//Get location by place_id
		Route::get( 'byPlaceID/{id}', 'LocationController@byPlaceID' );

		//Get location by text
		Route::get( 'byText/{text}', 'LocationController@byText' );
	} );

	/**
	 * API Direction
	 */
	Route::group( array( 'prefix' => 'direction' ), function () {
		//Get direction by Text query
		Route::get( 'byText/origin={origin}&destination={destination}',
			'DirectionController@byText' );

		//Get direction by origin coordinate & destination text
		Route::get( 'byMixed/origin={lat},{lng}&destination={destination}',
			'DirectionController@byMixed' );

		//Get direction by place_id
		Route::get( 'byPlaceID/origin={origin}&destination={destination}',
			'DirectionController@byPlaceID' );

		//Get direction by coordinates
		Route::get( 'byCoordinates/origin={lat_o},{lng_o}&destination={lat_d},{lng_d}',
			'DirectionController@byCoordinates' );
	} );

	/**
	 * GET/POST Status traffic
	 */
	Route::group( array( 'prefix' => 'traffic' ), function () {
		Route::get( 'postStatus/{type}/location={lat},{lng}',
			'TrafficController@postStatus' );

		Route::get( 'getStatus',
			'TrafficController@getStatusAll' );

		Route::get( 'getStatus/{type}',
			'TrafficController@getStatusByType' );

		Route::get( 'getStatusByName/{name}',
			'TrafficController@getStatusTrafficByStreet'
		);
	} );
} );

/**
 * API v2
 */
Route::group( array( 'prefix' => 'v2' ), function () {
	/**
	 * Question
	 */
	Route::group( [ 'prefix' => 'bot' ], function () {
		// Get solve question
		Route::any( 'chat', 'QuestionController@getAnswer' );

		Route::any( 'get', 'QuestionController@getAllQuestion' );
	} );
} );

/**
 * Documents
 */
Route::group( [ 'prefix' => 'docs' ], function () {
	Route::group( [ 'prefix' => 'v2' ], function () {
		Route::get( '/', 'DocumentController@index' );
		Route::get( 'bot', [
			'as'   => 'docs.v2.bot',
			'uses' => 'DocumentController@bot',
		] );
	} );
} );

/**
 * Web hook git
 */
Route::any( 'git', 'GitController@push' );


/**
 * Web page
 */
Route::get( '/', function () {
	return redirect()->route( 'home' );
} );

Route::get( 'home', [
	'as'   => 'home',
	'uses' => 'PageController@home'
] );

/**
 * Bot chat
 */
Route::group( [ 'prefix' => 'bot' ], function () {
	Route::get( '/', [
		'as'   => 'bot',
		'uses' => 'BotController@bot'
	] );

	Route::any( 'api', [
		'as'   => 'bot.api',
		'uses' => 'BotController@botChatAPI'
	] );

	Route::get( 'chat', [
		'as'   => 'bot.chat',
		'uses' => 'BotController@botChat'
	] );

	Route::get( 'setup', [
		'as'   => 'bot.setup',
		'uses' => 'BotController@getSetup'
	] );

	Route::post( 'setup', [
		'as'   => 'bot.setup',
		'uses' => 'BotController@postSetup'
	] );
} );

/**
 * Traffic
 */
Route::get( 'traffic', [
	'as'   => 'traffic',
	'uses' => 'PageController@traffic'
] );

/**
 * Download
 */
Route::group( [ 'prefix' => 'download' ], function () {
	Route::get( 'beta', [
		'as'   => 'download.beta',
		'uses' => 'PageController@downloadBeta'
	] );
} );