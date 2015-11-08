<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Helpers\Maps\FriesLocationDetails;
use App\Helpers\Maps\FriesLocationSearch;

class LocationController extends Controller {
	/**
	 * Get location by Coordinates
	 *
	 * @param  $lat
	 * @param  $lng
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byCoordinates( $lat, $lng ) {
		$lat            = trim( $lat );
		$lng            = trim( $lng );
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

	/**
	 * Get location by text
	 *
	 * @param $text
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byText( $text ) {
		$location_search = FriesLocationSearch::constructWithText( $text );
		$place_id        = $location_search->getPlaceIDbyIndex( 0 );

		return $this->byPlaceID( $place_id );
	}
}
