<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 13/10/2015
 * Time: 11:00 PM
 */

require_once 'location-search.php';

$location
	= FriesLocationSearch::constructWithText( 'So 69 Ho Tung Mau Ha Noi' );

//print_r( $location->getLocationDetailsByIndex( 0 )->getLocationCode() );

$location2 = FriesLocationSearch::constructWithLocation( '21.029212',
	'105.826691', 1 );

print_r( $location2->getLocationDetailsByIndex(0)->getURLGoogleMaps() );