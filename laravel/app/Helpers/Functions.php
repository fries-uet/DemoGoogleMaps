<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 22/10/2015
 * Time: 5:35 PM
 */

use App\Helpers\FriesProvince;

if ( ! function_exists( 'getResponseError' ) ) {
	/**
	 * Get Response Error
	 *
	 * @param string $code
	 * @param string $msg
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function getResponseError( $code = 'ERROR', $msg = '' ) {
		$response = [
			'status' => $code,
			'msg'    => $msg,
		];

		return response()->json( $response );
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
		'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c', // v1
		'AIzaSyCZDU3TY73EGrPpurkLtXN5zex88duEwwk', // tutv95
		'AIzaSyCoG4V5FmAkdSQio9QSQe7FutNtEua7hfQ', // v2
		'AIzaSyAGG6pQH6IvLpqbVIOOZeAT23zSZlpyMkw', // v3
		'AIzaSyBD3gLGTqoUObqUjU0KamImfHeecNjH0HA', // v4
//		'AIzaSyC-DxAuNhiB-RWfuCOp2nl6wW1J5DMuH2Y', // v5
		'AIzaSyDvVbsuHF5Eiq9YYfWfKA__edrwbuHbBio', // v6
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

function providerQuerySearch( $query, $city = null ) {
	if ( $city == null ) {
		return $query;
	}

	$city      = mb_strtolower( $city );
	$query     = mb_strtolower( $query );
	$provinces = new FriesProvince();
	foreach ( $provinces->getProvinces() as $index => $p ) {
		if ( strpos( $query, mb_strtolower( $p ) ) !== false ) {
			return $query;
		}
	}

	return $query . ' ' . $city;
}