<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/10/2015
 * Time: 10:29 PM
 */

require_once 'map-direction.php';

$origin      = 'B2, Dịch Vọng Hậu, Cầu Giấy';
$destination = '134 Mai Anh Tuấn, Ô Chợ Dừa, Đống Đa';

if ( isset( $_GET['origin'] ) ) {
	$origin = $_GET['origin'];
}

if ( isset( $_GET['destination'] ) ) {
	$destination = $_GET['destination'];
}

$map = FriesMaps::constructWithText( $origin, $destination );

print_r( json_encode( $map->getStepArrText() ) );

//$map2 = FriesMaps::constructWithPlaceID( 'ChIJRVpTUDWrNTER9DpRgvBxPYM',
//	'ChIJ7bFA_nqrNTERWBylw0xuHjo' );
//
//print_r( ( $map2->getStepArrText() ) );


