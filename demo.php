<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/10/2015
 * Time: 10:29 PM
 */

require_once 'maps.php';

$origin      = 'B2, Dich Vong Hau, Cau Giay';
$destination = '134 Mai Anh Tu?n, Ô Ch? D?a, ??ng ?a';

if ( isset( $_GET['origin'] ) ) {
	$origin = $_GET['origin'];
}

if ( isset( $_GET['destination'] ) ) {
	$destination = $_GET['destination'];
}

$map2 = FriesMaps::constructWithPlaceID( 'ChIJRVpTUDWrNTER9DpRgvBxPYM',
	'ChIJ7bFA_nqrNTERWBylw0xuHjo' );

print_r( ( $map2->getStepArrText() ) );


