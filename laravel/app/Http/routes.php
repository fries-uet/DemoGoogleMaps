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

	/**
	 * Development
	 */
	Route::get(
		'test',
		'TrafficController@test'
	);

	Route::post(
		'testPost',
		'TestController@testPost'
	);

	Route::get(
		'testGet',
		'TestController@testGet'
	);
} );

/**
 * API v2
 */
Route::group( array( 'prefix' => 'v2' ), function () {
	/**
	 * API Direction
	 */
	Route::group( array( 'prefix' => 'direction' ), function () {
		//Get direction by origin coordinate & destination text
		Route::any( 'byMixed',
			'DirectionController@byMixedPost' );
	} );

	/**
	 * API Location
	 */
	Route::group( [ 'prefix' => 'location' ], function () {
		Route::any( 'byText', 'LocationController@byTextPost' );
	} );

	/**
	 * Question
	 */
	Route::group( [ 'prefix' => 'bot' ], function () {
		Route::any( 'chat', 'QuestionController@getAnswer' );
		Route::any( 'get', 'QuestionController@getAllQuestion' );
	} );
} );

Route::group( [ 'prefix' => 'web' ], function () {
	Route::get( 'bot', 'QuestionController@webGetAll' );
} );

/**
 * Webhook git
 */
Route::any( 'git', 'GitController@push' );
/**
 *
 */