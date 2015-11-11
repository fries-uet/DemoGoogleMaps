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
	 * @param string $way_point
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byMixed( $lat, $lng, $destination, $way_point = null ) {
		$lat = trim( $lat );
		$lng = trim( $lng );

		$origin      = FriesLocationSearch::constructWithLocation( $lat, $lng );
		$destination = FriesLocationSearch::constructWithText( $destination );

		$origin_place_id      = $origin->getPlaceIDbyIndex();
		$destination_place_id = $destination->getPlaceIDbyIndex();
		if ( $way_point != null ) {
			$way_point_id
				= FriesLocationSearch::constructWithText( $way_point )
				                     ->getPlaceIDbyIndex();

			return $this->byPlaceID( $origin_place_id, $destination_place_id,
				$way_point_id );
		}

		return $this->byPlaceID(
			$origin_place_id,
			$destination_place_id );
	}

	/**
	 * Direction by place_id
	 *
	 * @param string $origin
	 * @param string $destination
	 * @param string $way_point
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byPlaceID( $origin, $destination, $way_point = null ) {
		if ( $way_point != null ) {
			$direction = FriesMaps::constructWithPlaceID(
				$origin,
				$destination,
				[ $way_point ]
			);
		} else {
			$direction = FriesMaps::constructWithPlaceID(
				$origin,
				$destination
			);
		}

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

	/**
	 * Direction by type of location
	 *
	 * @param $my_latitude
	 * @param $my_longitude
	 * @param $type
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byToType( $my_latitude, $my_longitude, $type ) {
		$origin_id
			= FriesLocationSearch::constructWithLocation( $my_latitude,
			$my_longitude )->getPlaceIDbyIndex();

		$destination_id = FriesLocationSearch::constructWithType( $my_latitude,
			$my_longitude, $type )->getPlaceIDbyIndex();

		return $this->byPlaceID( $origin_id, $destination_id );
	}

	public function byWayType(
		$my_latitude, $my_longitude, $destination,
		$type_location
	) {
		$origin_id
			= FriesLocationSearch::constructWithLocation( $my_latitude,
			$my_longitude )->getPlaceIDbyIndex();

		$destination_id
			          = FriesLocationSearch::constructWithText( $destination )->getPlaceIDbyIndex();
		$way_point_id = FriesLocationSearch::constructWithType( $my_latitude,
			$my_longitude, $type_location )->getPlaceIDbyIndex();

		return $this->byPlaceID( $origin_id, $destination_id,
			$way_point_id );
	}
}
