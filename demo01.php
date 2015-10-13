<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 12/10/2015
 * Time: 10:09 PM
 */

require_once 'fries-location.php';

$location = new FriesLocation( 'ChIJo0p_T1yeNTEReIS4iYF2abo' );

print_r( $location->getStatus() );