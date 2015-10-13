<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 12/10/2015
 * Time: 10:09 PM
 */

require_once 'libs/location-details.php';

$location
	= new FriesLocationDetails( 'ChIJRVpTUDWrNTER9DpRgvBxPYM' );

print_r( $location->getAddressHTML() );