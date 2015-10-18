<?php
/**
 * Get direction by text
 */

require_once '../libs/map-direction.php';

if ( ! isset( $_GET['origin'] ) || ! isset( $_GET['destination'] ) ) {
	die();
} else {
	$origin      = $_GET['origin'];
	$destination = $_GET['destination'];
	$map         = FriesMaps::constructWithText( $origin, $destination );

	print_r( json_encode( $map->getOutput() ) );
}