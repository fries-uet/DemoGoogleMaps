<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 14/10/2015
 * Time: 11:44 PM
 */

require_once '../libs/location-search.php';

if ( ! isset( $_GET['lat'] ) || ! isset( $_GET['lng'] ) ) {
	die( '' );
} else {
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];

	$location = FriesLocationSearch::constructWithLocation( $lat, $lng );

	print_r( $location->getLocationDetailsByIndex( 0 )->getAddressFormatted() );
}