<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 13/10/2015
 * Time: 11:00 PM
 */

require_once 'libs/location-search.php';

$location2 = FriesLocationSearch::constructWithLocation( '21.038225',
	'105.782291' );

$place_id = $location2->getPlaceIDbyIndex( 0 );

print_r( $place_id );
