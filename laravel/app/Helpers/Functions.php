<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 22/10/2015
 * Time: 5:35 PM
 */

if ( ! function_exists( 'getResponseError' ) ) {
	/**
	 * Get Response Error
	 *
	 * @param $code
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function getResponseError( $code = 'ERROR' ) {
		return response()->json( [
			'status' => $code,
		] );
	}
}

if ( ! function_exists( 'convertCountTimestamp2String' ) ) {
	/**
	 * Convert count timestamp to String
	 *
	 * @param $timestamp
	 *
	 * @return string
	 */
	function convertCountTimestamp2String( $timestamp ) {
		$timestamp = intval( $timestamp );
		$string    = '';
		if ( $timestamp >= 86400 ) {
			$days      = intval( $timestamp / 86400 );
			$timestamp = $timestamp % 86400;
			$string .= $days . ' ngày';
		}

		if ( $timestamp >= 3600 ) {
			$hours     = intval( $timestamp / 3600 );
			$timestamp = $timestamp % 3600;
			$string .= ' ' . $hours . ' giờ';
		}

		if ( $timestamp >= 0 ) {
			$minutes = intval( $timestamp / 60 );
			if ( $minutes == 0 ) {
				$minutes = 1;
			}
			$string .= ' ' . $minutes . ' phút';
		}

		return trim( $string );
	}
}

function getGoogleMapsKeyAPI( $index = null ) {
	$key = [
//		'AIzaSyCoG4V5FmAkdSQio9QSQe7FutNtEua7hfQ', // v2
		'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c', // v1
//		'AIzaSyCZDU3TY73EGrPpurkLtXN5zex88duEwwk', // tutv95
//		'AIzaSyAGG6pQH6IvLpqbVIOOZeAT23zSZlpyMkw', // v3
	];

	if ( $index > count( $key ) - 1 || $index == null ) {
		$index = rand( 0, count( $key ) - 1 );
	}

	return $key[ $index ];
}

/**
 * Only allowed POST Request | Abort 404 when request different POST request
 *
 * @param $request
 */
function onlyAllowPostRequest( $request ) {
	if ( method_exists( $request, 'getMethod' )
	     && $request->getMethod() !== 'POST'
	) {
		abort( 404 );
	}
}