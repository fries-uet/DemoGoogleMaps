<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 13/10/2015
 * Time: 11:00 PM
 */

require_once 'location-search.php';

$location
	= FriesLocationSearch::constructWithText( 'So 69 Ho Tung Mau Ha Noi' );

print_r( $location->getObjectAPI() );