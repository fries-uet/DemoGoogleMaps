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
		Route::get( 'byCoordinates/lat={lat}&lng={lng}',
			'LocationController@byCoordinates' );

		//Get location by place_id
		Route::get( 'byPlaceID/id={id}', 'LocationController@byPlaceID' );
	} );

	/**
	 * API Direction
	 */
	Route::group( array( 'prefix' => 'direction' ), function () {
		// Get direction by Text query
		Route::get( 'byText/origin={origin}&destination={destination}',
			'DirectionController@byText' );

		// Get direction by place_id
		Route::get( 'byPlaceID/origin={origin}&destination={destination}',
			'DirectionController@byPlaceID' );

		// Get direction by coordinates
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
			'TrafficController@getStatus' );
	} );

	/**
	 * Development
	 */
	Route::get( '/test/query={query}',
		'TestController@test' );
} );
