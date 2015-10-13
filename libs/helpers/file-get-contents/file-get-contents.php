<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 14/10/2015
 * Time: 1:12 AM
 */

require_once 'unirest/Unirest.php';

/**
 * Get content from url via unirest.io
 *
 * @param $url
 *
 * @return mixed
 */
function fries_file_get_contents( $url ) {
	$obj_unirest = Unirest\Request::get( $url, null, null );
	$content     = $obj_unirest->raw_body;

	return $content;
}