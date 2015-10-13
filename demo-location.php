<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 12/10/2015
 * Time: 10:09 PM
 */

require_once 'location-details.php';

$location
	= new FriesLocationDetails( 'ChIJkYbPQP0AThMRmcAa7eGbhiE' );

print_r( $location->getAddressHTML() );