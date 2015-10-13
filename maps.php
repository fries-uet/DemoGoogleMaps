<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/10/2015
 * Time: 10:55 PM
 */

require_once 'unirest/Unirest.php';
require_once 'location-details.php';

class FriesMaps {
	const KEY_MAPS = 'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c';
	var $response_API;

	var $origin;
	var $destination;

	// Optional
	var $language = 'vi';//Vietnamese
	var $region = 'vn';//Vietnamese

	/**
	 * Travel Modes
	 *
	 * @var string: driving, walking, walking, transit
	 */
	var $mode;

	/**
	 * Object response
	 *
	 * @var object
	 */
	var $response;

	/**
	 * Construction
	 *
	 * @param $origin
	 * @param $destination
	 * @param $mode
	 */
	function __construct( $origin, $destination, $mode = 'driving' ) {
		$this->origin      = $origin;
		$this->destination = $destination;
		$this->mode        = $mode;

		$this->response_API = $this->getContentAPI();

		$this->response = new stdClass();
		$this->constructResult();
	}

	public function getResult() {
		return $this->response;
	}

	public function constructResult() {
		// Request
		$request              = new stdClass();
		$request->origin      = $this->origin;
		$request->destination = $this->destination;
		$request->mode        = $this->mode;

		$this->response->request = $request;

		if ( ! $this->getStatus() ) {
			$this->response->status = 'FAILED';
		} else {
			$this->response->status = 'OK';

			//Result
			$result           = new stdClass();
			$result->distance = $this->getDistance();
			$result->duration = $this->getDuration();

			$result->origin_detect           = new stdClass();
			$result->origin_detect->text     = $this->getAddressOrigin();
			$result->origin_detect->geocoded = $this->getLegs()->start_location;

			$result->destination_detect = new stdClass();
			$result->destination_detect->text
			                            = $this->getAddressDestination();
			$result->destination_detect->geocoded
			                            = $this->getLegs()->end_location;

			$result->stepsText = $this->getStepArrText();

			$this->response->result = $result;
		}
	}

	/**
	 * Get content response from Google Maps web service
	 *
	 * @return mixed
	 */
	public function getContentAPI() {
		$url_api     = sprintf(
			'https://maps.googleapis.com/maps/api/directions/json?origin=%s&destination=%s&key=%s&language=%s&mode=%s&region=%s',
			urlencode( $this->origin ), urlencode( $this->destination ),
			self::KEY_MAPS, $this->language, $this->mode, $this->region
		);
		$obj_unirest = Unirest\Request::get( $url_api, null, null );
		$content     = $obj_unirest->raw_body;

		return $content;
	}

	/**
	 * Get Object response from Google Maps web service
	 *
	 * @return mixed
	 */
	public function getObjectAPI() {
		$object = json_decode( $this->response_API );

		return $object;
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
	 * Get Geometry coding
	 *
	 * @param int $index
	 *
	 * @return mixed
	 */
	public function getGeoCoded( $index = 0 ) {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$object = $this->getObjectAPI();

		return $object->geocoded_waypoints[ $index ];
	}

	/**
	 * Get Geocoding status
	 *
	 * @param int $index
	 *
	 * @return mixed
	 */
	public function getGeoCodedStatus( $index = 0 ) {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$geoCoded = $this->getGeoCoded( $index );

		return $geoCoded->geocoder_status;
	}


	/**
	 * Get Routes
	 *
	 * @return mixed
	 */
	public function getRoutes() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$object = $this->getObjectAPI();

		return $object->routes[0];
	}

	/**
	 * Get Legs: distance, duration, end_address, start_address, steps,...
	 *
	 * @return mixed
	 */
	public function getLegs() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$routes = $this->getRoutes();

		return $routes->legs[0];
	}

	/**
	 * Get Distance
	 *
	 * @return mixed
	 */
	public function getDistance() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		return $legs->distance;
	}

	/**
	 * Get Duration
	 *
	 * @return mixed
	 */
	public function getDuration() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		return $legs->duration;
	}

	/**
	 * Get AddressOrigin
	 *
	 * @return mixed
	 */
	public function getAddressOrigin() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		return $legs->start_address;
	}

	/**
	 * Get Address Destination
	 *
	 * @return mixed
	 */
	public function getAddressDestination() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		return $legs->end_address;
	}

	/**
	 * Get steps
	 *
	 * @return mixed
	 */
	public function getSteps() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		return $legs->steps;
	}

	/**
	 * Get Direction by Array HTML
	 *
	 * @return array
	 */
	public function getStepArrHTML() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$steps = $this->getSteps();

		$html = array();

		foreach ( $steps as $step ) {
			array_push( $html, '<div>' . $step->html_instructions );
		}

		return $html;
	}

	/**
	 * Get Direction by Array Text
	 *
	 * @return array
	 */
	public function getStepArrText() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$steps      = $this->getStepArrHTML();
		$steps_text = array();

		foreach ( $steps as $index => $step ) {
			$step = str_replace( '<div style="',
				'. <div style="', $step );
			$step = html_entity_decode( $step );
			array_push( $steps_text, strip_tags( $step ) );
		}

		return $steps_text;
	}

	public function getOriginLocation() {

	}
}