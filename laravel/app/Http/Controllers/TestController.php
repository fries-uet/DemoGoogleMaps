<?php

namespace App\Http\Controllers;

use App\Helpers\Maps\FriesLocationSearch;
use App\Helpers\Maps\FriesMaps;
use App\Http\Requests;

class TestController extends Controller {
	public function test( $origin, $destination, $waypoint ) {
		$origin_id      = FriesLocationSearch::constructWithText( $origin )
		                                     ->getPlaceIDbyIndex();
		$destination_id = FriesLocationSearch::constructWithText( $destination )
		                                     ->getPlaceIDbyIndex();
		$waypoint_id    = FriesLocationSearch::constructWithText( $waypoint )
		                                     ->getPlaceIDbyIndex();

		$direction = FriesMaps::constructWithPlaceID( $origin_id,
			$destination_id, [ $waypoint_id ] );

		return response()->json( $direction->getOutput() );
	}
}