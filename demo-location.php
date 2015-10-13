<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 12/10/2015
 * Time: 10:09 PM
 */

require_once 'location-details.php';

$location
	= new FriesLocationDetails( 'ChIJm4Y1uRWrNTERqqByoyUlrX8' );

print_r( $location->getAddressHTML() );