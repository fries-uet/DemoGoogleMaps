<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 15/10/2015
 * Time: 12:15 AM
 */

require_once '../libs/map-direction.php';

if ( ! isset( $_GET['origin'] ) || ! isset( $_GET['destination'] ) ) {
	die();
} else {
	$origin      = $_GET['origin'];
	$destination = $_GET['destination'];
	$map         = FriesMaps::constructWithText( $origin, $destination );

	print_r( $map->getObjectAPI() );
}