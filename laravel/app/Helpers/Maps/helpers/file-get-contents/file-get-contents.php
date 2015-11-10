<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 14/10/2015
 * Time: 1:12 AM
 */

require_once __DIR__ . '/unirest/Unirest.php';

/**
 * Get content from url via unirest.io
 *
 * @param $url
 * @param $header
 * @param $body
 *
 * @return mixed
 */
function fries_file_get_contents( $url, $header = null, $body = null ) {
	try {
		$obj_unirest = Unirest\Request::get( $url, $header, $body );
		$content     = $obj_unirest->raw_body;

		return $content;
	} catch ( Exception $e ) {
		$view = getResponseError( 'ERROR', $e->getMessage() );
		$view->send();
		die();
	}
}

function fries_post_contents( $url, $header = null, $body = null ) {
	try {
		$obj_unirest = Unirest\Request::post( $url, $header, $body );
		$content     = $obj_unirest->raw_body;

		return $content;
	} catch ( Exception $e ) {
		$view = getResponseError( 'ERROR', $e->getMessage() );
		$view->send();
		die();
	}
}