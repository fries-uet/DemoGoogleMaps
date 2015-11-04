<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 13/10/2015
 * Time: 10:37 PM
 */

namespace App\Helpers\Maps;

require_once 'helpers/file-get-contents/file-get-contents.php';
require_once 'location-details.php';

class FriesLocationSearch {
	var $KEY_API = 'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c';

	var $response_API;
	var $response_Object_API;
	var $url_API;

	/**
	 * @var string
	 */
	var $query;
	var $latitude;
	var $longitude;
	var $radius;

	/**
	 * Optional
	 */
	var $language;
	var $region;

	/**
	 * Construction
	 */
	private function __construct() {
		$this->language = 'vi';
		$this->region   = 'vn';//Vietnam
		$this->KEY_API  = getGoogleMapsKeyAPI();
	}

	/**
	 * Construction with text query
	 *
	 * @param string $query
	 * @param array  $location : latitude & longitude
	 * @param int    $radius
	 *
	 * @return FriesLocationSearch
	 */
	public static function constructWithText(
		$query, $location = null, $radius = 10000
	) {
		$instance        = new self();
		$instance->query = $query;

		$instance->url_API
			= sprintf( 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=%s&key=%s&language=%s',
			urlencode( $instance->query ), $instance->KEY_API,
			$instance->language );

		if ( $location != null ) {
			$instance->url_API = $instance->url_API
			                     . sprintf( '&location=%s,%s&radius=%s',
					$location['latitude'], $location['longitude'], $radius );
		}

//		dd( $instance->url_API );

		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * Construction with coordinates
	 *
	 * @param     $lat
	 * @param     $lng
	 * @param int $radius
	 *
	 * @return FriesLocationSearch
	 */
	public static function constructWithLocation( $lat, $lng, $radius = 10 ) {
		$instance            = new self();
		$instance->latitude  = $lat;
		$instance->longitude = $lng;
		$instance->radius    = $radius;

		$instance->url_API
			= sprintf( 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=%s,%s&radius=%s&key=%s&language=%s',
			$instance->latitude, $instance->longitude, $instance->radius,
			$instance->KEY_API, $instance->language );

		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * Get content response from Google Maps web service
	 *
	 * @return mixed
	 */
	private function getContentAPI() {
		$content = fries_file_get_contents( $this->url_API );

		return $content;
	}

	/**
	 * Handle response from API
	 */
	public function handleResponseAPI() {
		$this->response_API        = $this->getContentAPI();
		$this->response_Object_API = json_decode( $this->response_API );
	}

	/**
	 * Get Object response from Google Maps web service
	 *
	 * @return mixed
	 */
	public function getObjectAPI() {
		return $this->response_Object_API;
	}

	/**
	 * Get status response
	 *
	 * @return bool
	 */
	public function getStatus() {
		$object = $this->getObjectAPI();
		$status = $object->status;

		if ( $status === 'OK' ) {
			return true;
		}

		return false;
	}

	/**
	 *  Get results
	 *
	 * @return null, object
	 */
	public function getResults() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$object = $this->getObjectAPI();

		return $object->results;
	}

	/**
	 * Count results
	 *
	 * @return int
	 */
	public function countResults() {
		return count( $this->getResults() );
	}

	/**
	 * Get Array Address Formatted
	 *
	 * @return array|null
	 */
	public function getArrAddressFormatted() {
		if ( $this->countResults() == 0 ) {
			return null;
		}
		$arr_result  = $this->getResults();
		$arr_address = array();
		foreach ( $arr_result as $result ) {
			array_push( $arr_address, $result->formatted_address );
		}

		return $arr_address;
	}

	/**
	 * Get Address Formatted by index
	 *
	 * @param int $index
	 *
	 * @return mixed
	 */
	public function getAddressFormattedByIndex( $index = 0 ) {
		if ( $index > $this->getMaxIndex() || $index < 0
		     || ! is_numeric( $index )
		) {
			$index = 0;
		}

		return $this->getArrAddressFormatted()[ $index ];
	}

	/**
	 * Get Array place_id
	 *
	 * @return array|null
	 */
	public function getArrPlaceID() {
		if ( $this->countResults() == 0 ) {
			return null;
		}
		$placeIDs = array();
		$results  = $this->getResults();

		foreach ( $results as $result ) {
			array_push( $placeIDs, $result->place_id );
		}

		return $placeIDs;
	}

	/**
	 * Get max index
	 *
	 * @return int
	 */
	public function getMaxIndex() {
		return $this->countResults() - 1;
	}

	/**
	 * Get place_id by index
	 *
	 * @param $index
	 *
	 * @return null|string
	 */
	public function getPlaceIDbyIndex( $index = 0 ) {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$arr_placeIDs = $this->getArrPlaceID();

		return $arr_placeIDs[ $index ];
	}

	/**
	 * Get Location details by index
	 *
	 * @param $index
	 *
	 * @return FriesLocationDetails|null
	 */
	public function getLocationDetailsByIndex( $index ) {
		if ( ! $this->getStatus() ) {
			return null;
		}

		$place_id         = $this->getPlaceIDbyIndex( $index );
		$location_details = new FriesLocationDetails( $place_id );

		return $location_details;
	}
}