<?php
/**
 * Get place details by place_id
 */

require_once '../libs/location-details.php';

if ( ! isset( $_GET['place_id'] ) ) {
	die();
} else {
	$place_id = $_GET['place_id'];
	$location = new FriesLocationDetails( $place_id );

	print_r( $location->getAddressFormatted() );
}