<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\Maps\FriesLocationDetails;
use App\Helpers\Maps\FriesLocationSearch;

class LocationController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view( 'welcome' );
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

	/**
	 * Get location by Coordinates
	 *
	 * @param null $lat
	 * @param null $lng
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byCoordinates( $lat = null, $lng = null ) {
		$locationSearch = FriesLocationSearch::constructWithLocation( $lat,
			$lng );

		$locationDetail
			= new FriesLocationDetails( $locationSearch->getPlaceIDbyIndex( 0 ) );

		return response()->json( $locationDetail->getOutput() );
	}

	/**
	 * Get location by place_id
	 *
	 * @param $place_id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byPlaceID( $place_id ) {
		$location = new FriesLocationDetails( $place_id );

		return response()->json( $location->getOutput() );
	}
}
