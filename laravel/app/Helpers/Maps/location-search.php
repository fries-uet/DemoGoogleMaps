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
	const KEY_MAPS = 'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c';

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

	/**
	 * Construction
	 */
	private function __construct() {
		$this->language = 'vi';
	}

	/**
	 * Construction with text query
	 *
	 * @param $query
	 *
	 * @return FriesLocationSearch
	 */
	public static function constructWithText( $query ) {
		$instance        = new self();
		$instance->query = $query;

		$instance->url_API
			= sprintf( 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=%s&key=%s',
			urlencode( $instance->query ), self::KEY_MAPS );

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
			= sprintf( 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=%s,%s&radius=%s&key=%s',
			$instance->latitude, $instance->longitude, $instance->radius,
			self::KEY_MAPS );

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
	 * Get place_id by index
	 *
	 * @param $index
	 *
	 * @return null
	 */
	public function getPlaceIDbyIndex( $index ) {
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