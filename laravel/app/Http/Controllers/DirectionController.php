<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\Maps\FriesMaps;
use App\Helpers\Maps\FriesLocationSearch;
use App\Helpers\Maps\FriesLocationDetails;

class DirectionController extends Controller {
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

	/**
	 * Direction by Text query
	 *
	 * @param $origin
	 * @param $destination
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byText( $origin, $destination ) {
		$direction = FriesMaps::constructWithText( $origin, $destination );

		return response()->json( $direction->getOutput() );
	}

	/**
	 *
	 *
	 * @param        $lat : Latitude origin
	 * @param        $lng : Longitude Origin
	 * @param string $destination
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byMixed( $lat, $lng, $destination ) {
		$lat         = trim( $lat );
		$lng         = trim( $lng );
		$origin      = FriesLocationSearch::constructWithLocation( $lat, $lng );
		$destination = FriesLocationSearch::constructWithText( $destination );

		$origin_place_id       = $origin->getPlaceIDbyIndex();
		$destination_place_id  = $destination->getPlaceIDbyIndex();
		$destination_formatted = $destination->getAddressFormattedByIndex();

		$args = [
			'lat_origin'  => $lat,
			'lng_origin'  => $lng,
			'destination' => $destination_formatted,
		];

		return $this->byPlaceID(
			$origin_place_id,
			$destination_place_id,
			'coor_text'
		);
	}

	/**
	 * Direction by place_id
	 *
	 * @param string $origin
	 * @param string $destination
	 * @param string $type
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byPlaceID( $origin, $destination, $type = 'place_id' ) {
		$direction = FriesMaps::constructWithPlaceID(
			$origin,
			$destination,
			$type
		);

		return response()->json( $direction->getObjectAPI() );
	}

	/**
	 * Direction by Coordinates
	 *
	 * @param $lat_o
	 * @param $lng_o
	 * @param $lat_d
	 * @param $lng_d
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byCoordinates( $lat_o, $lng_o, $lat_d, $lng_d ) {
		$origin['lat']      = $lat_o;
		$origin['lng']      = $lng_o;
		$destination['lat'] = $lat_d;
		$destination['lng'] = $lng_d;

		$direction = FriesMaps::constructWithCoordinates(
			$origin,
			$destination
		);

		return response()->json( $direction->getOutput() );
	}
}
