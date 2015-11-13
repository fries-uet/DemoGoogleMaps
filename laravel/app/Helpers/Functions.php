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
//		'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c', // v1
		'AIzaSyCZDU3TY73EGrPpurkLtXN5zex88duEwwk', // tutv95
		'AIzaSyCoG4V5FmAkdSQio9QSQe7FutNtEua7hfQ', // v2
		'AIzaSyAGG6pQH6IvLpqbVIOOZeAT23zSZlpyMkw', // v3
		'AIzaSyBD3gLGTqoUObqUjU0KamImfHeecNjH0HA', // v4
		'AIzaSyC-DxAuNhiB-RWfuCOp2nl6wW1J5DMuH2Y', // v5
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

function f_distance( $lat1, $lng1, $lat2, $lng2 ) {
	$r     = 6371000;
	$lat_x = deg2rad( $lat1 );
	$lat_y = deg2rad( $lat2 );

	$delta_lat = deg2rad( $lat2 - $lat1 );
	$delta_lng = deg2rad( $lng2 - $lng1 );

	$a = sin( $delta_lat / 2 ) * sin( $delta_lat / 2 ) +
	     cos( $lat_x ) * cos( $lat_y ) * sin( $delta_lng / 2 )
	     * sin( $delta_lng / 2 );
	$c = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ) );

	return $r * $c;
}

/**
 * Get price gas A92 & A95
 *
 * @return array
 */
function getPriceGas() {
	$url_gas = 'http://www.petrolimex.com.vn';
	$content = fries_file_get_contents( $url_gas );

	try {
		$content = explode( 'vie_p3_PortletContent', $content )[1];
		$content = explode( 'blueseaContainerFooter', $content )[0];

		$a95 = explode( 'Xăng RON 95</a></div><div class="c">', $content )[1];
		$a95 = explode( '</div>', $a95 )[0];

		$a92 = explode( 'Xăng RON 92</a></div><div class="c">', $content )[1];
		$a92 = explode( '</div>', $a92 )[0];

		return [
			'a92' => $a92,
			'a95' => $a95,
		];
	} catch ( Exception $e ) {
		$view = getResponseError( 'ERROR', $e->getMessage() );
		$view->send();
		die();
	}
}

function convertPriceToText( $price ) {
	$str = '';
	$arr = explode( '.', $price );
	$t   = $arr[0];
	$str .= $t . ' nghìn';

	if ( count( $arr ) > 1 ) {
		$d = $arr[1];
		$str .= ' ' . $d . ' đồng';
	}

	return $str;
}

function convertStatusTrafficToVietnamese( $type ) {
	$arr = [
		'congestion' => 'tắc đường',
		'open'       => 'thông xe',
	];

	return $arr[ $type ];
}