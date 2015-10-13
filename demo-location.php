<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 12/10/2015
 * Time: 10:09 PM
 */

require_once 'location-details.php';

$location
	= new FriesLocationDetails( 'EkQ2OSBI4buTIFTDuW5nIE3huq11LCBNYWkgROG7i2NoLCBD4bqndSBHaeG6pXksIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ' );

print_r( $location->getURLGoogleMaps() );