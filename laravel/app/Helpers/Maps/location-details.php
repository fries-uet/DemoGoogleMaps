<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 12/10/2015
 * Time: 9:55 PM
 */

namespace App\Helpers\Maps;

require_once 'helpers/file-get-contents/file-get-contents.php';

class FriesLocationDetails {
	const KEY_MAPS = 'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c';
	var $url_API;

	var $response_API;
	var $response_Object_API;

	/**
	 * @var string
	 */
	var $place_id;

	/**
	 * Optional
	 */
	var $language = 'vi';

	function __construct( $place_id ) {
		$this->place_id = $place_id;

		$this->handleResponseAPI();
	}

	/**
	 * Get content response from Google Maps web service
	 *
	 * @return mixed
	 */
	public function getContentAPI() {
		$this->url_API = sprintf(
			'https://maps.googleapis.com/maps/api/place/details/json?placeid=%s&key=%s&language=%s',
			$this->place_id, self::KEY_MAPS, $this->language
		);
		$content       = fries_file_get_contents( $this->url_API );

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
	 *  Get result
	 *
	 * @return null, object
	 */
	public function getResult() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$object = $this->getObjectAPI();

		return $object->result;
	}

	/**
	 * Get Address was formatted
	 *
	 * @return null, text
	 */
	public function getAddressFormatted() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$result = $this->getResult();

		return $result->formatted_address;
	}

	/**
	 * Get Address HTML
	 *
	 * @return null, text(html)
	 */
	public function getAddressHTML() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$result = $this->getResult();

		return $result->adr_address;
	}

	/**
	 *  Get Geometry
	 *
	 * @return null, object geometry {location: {lat, lng} }
	 */
	public function getGeometry() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$result = $this->getResult();

		return $result->geometry;
	}

	/**
	 * Get Location code
	 *
	 * @return null, location code
	 */
	public function getLocationCode() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$geometry = $this->getGeometry();

		return $geometry->location;

	}

	/**
	 * Get latitude
	 *
	 * @return null, string
	 */
	public function getLatitude() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$location = $this->getLocationCode();

		return $location->lat;
	}

	/**
	 * Get longitude
	 *
	 * @return null, string
	 */
	public function getLongitude() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$location = $this->getLocationCode();

		return $location->lng;
	}

	/**
	 * GET URL on Google Maps
	 */
	public function getURLGoogleMaps() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$result = $this->getResult();

		return $result->url;
	}

	/**
	 * Get place_id;
	 *
	 * @return null
	 */
	public function getPlaceID() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$result = $this->getResult();

		return $result->place_id;
	}

	/**
	 * Get output
	 *
	 * @return array
	 */
	public function getOutput() {
		if ( $this->getStatus() ) {
			return array(
				'status'            => 'ok',
				'address_formatted' => $this->getAddressFormatted()
			);
		} else {
			return array( 'status' => 'error' );
		}
	}
}