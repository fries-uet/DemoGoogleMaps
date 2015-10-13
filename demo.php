<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/10/2015
 * Time: 10:29 PM
 */

require_once 'maps.php';

$origin      = '193 Ho Tung Mau';
$destination = 'Nha Hat Lon HN';

if ( isset( $_GET['origin'] ) ) {
	$origin = $_GET['origin'];
}

if ( isset( $_GET['destination'] ) ) {
	$destination = $_GET['destination'];
}

$map = new FriesMaps( $origin, $destination );

print_r( ( $map->getContentAPI() ) );


