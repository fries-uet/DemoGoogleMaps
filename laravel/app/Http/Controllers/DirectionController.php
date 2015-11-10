<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Helpers\Maps\FriesMaps;
use App\Helpers\Maps\FriesLocationSearch;

class DirectionController extends Controller {
	/**
	 * Direction by Text query
	 *
	 * @param $origin
	 * @param $destination
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byText( $origin, $destination ) {
		$origin_id      = FriesLocationSearch::constructWithText( $origin )
		                                     ->getPlaceIDbyIndex();
		$destination_id = FriesLocationSearch::constructWithText( $destination )
		                                     ->getPlaceIDbyIndex();
		$direction      = FriesMaps::constructWithPlaceID( $origin_id,
			$destination_id );

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
		$lat = trim( $lat );
		$lng = trim( $lng );

		$origin      = FriesLocationSearch::constructWithLocation( $lat, $lng );
		$destination = FriesLocationSearch::constructWithText( $destination );

		$origin_place_id      = $origin->getPlaceIDbyIndex();
		$destination_place_id = $destination->getPlaceIDbyIndex();

		return $this->byPlaceID(
			$origin_place_id,
			$destination_place_id,
			'direction'
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
	public function byPlaceID( $origin, $destination, $type = 'direction' ) {
		$direction = FriesMaps::constructWithPlaceID(
			$origin,
			$destination,
			$type
		);

		return response()->json( $direction->getOutput() );
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
