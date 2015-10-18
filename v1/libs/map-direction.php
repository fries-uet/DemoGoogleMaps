<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/10/2015
 * Time: 10:55 PM
 */

require_once 'helpers/file-get-contents/file-get-contents.php';
require_once 'location-details.php';

class FriesMaps {
	const KEY_MAPS = 'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c';
	var $response_API;
	var $response_Object_API;
	var $url_api;

	var $origin;
	var $destination;

	// Optional
	var $language;
	var $region;

	/**
	 * Travel Modes
	 *
	 * @var string: driving, walking, walking, transit
	 */
	var $mode;

	/**
	 * Object response (output)
	 *
	 * @var object
	 */
	var $response;

	/**
	 * Construction
	 *
	 * @param        $origin
	 * @param        $destination
	 * @param string $mode
	 */
	private function __construct( $origin, $destination, $mode = 'driving' ) {
		$this->language    = 'vi';//Vietnamese
		$this->region      = 'vn';//Vietnam
		$this->origin      = $origin;
		$this->destination = $destination;
		$this->mode        = $destination;
	}

	/**
	 * Construction with place text
	 *
	 * @param        $origin
	 * @param        $destination
	 * @param string $mode
	 *
	 * @return FriesMaps
	 */
	public static function constructWithText(
		$origin, $destination, $mode = 'driving'
	) {
		$instance = new self( $origin, $destination, $mode );
		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * Contruction with place id
	 *
	 * @param        $origin
	 * @param        $destination
	 * @param string $mode
	 *
	 * @return FriesMaps
	 */
	public static function constructWithPlaceID(
		$origin, $destination, $mode = 'driving'
	) {
		$instance              = new self( $origin, $destination, $mode );
		$instance->origin      = 'place_id:' . $origin;
		$instance->destination = 'place_id:' . $destination;
		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * Get content response from Google Maps web service
	 *
	 * @return mixed
	 */
	public function getContentAPI() {
		$this->url_api = sprintf(
			'https://maps.googleapis.com/maps/api/directions/json?origin=%s&destination=%s&key=%s&language=%s&mode=%s&region=%s',
			urlencode( $this->origin ), urlencode( $this->destination ),
			self::KEY_MAPS, $this->language, $this->mode,
			$this->region
		);

		$content = fries_file_get_contents( $this->url_api );

		return $content;
	}

	/**
	 * Handle response from API
	 */
	public function handleResponseAPI() {
		$this->response_API        = $this->getContentAPI();
		$this->response_Object_API = json_decode( $this->response_API );
		$this->setOutput();
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
	 * @param bool|false $text
	 *
	 * @return null|mixed
	 */
	public function getDistance( $text = false ) {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		if ( $text === true ) {
			return $legs->distance->text;
		}

		return $legs->distance;
	}

	/**
	 * Get Duration
	 *
	 * @param bool|false $text
	 *
	 * @return null|mixed
	 */
	public function getDuration( $text = false ) {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs();

		if ( $text === true ) {
			return $legs->duration->text;
		}

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
			array_push( $html, $step->html_instructions );
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

	/**
	 * Get step by step
	 */
	public function getStepByStep() {
		if ( ! $this->getStatus() ) {
			return null;
		}

		$steps     = $this->getSteps();
		$new_steps = array();
		foreach ( $steps as $step ) {
			$new_step           = new stdClass();
			$new_step->distance = $step->distance->text;
			$new_step->duration = $step->duration->text;

			/**
			 * Split main text and info text
			 */
			$instructions = $step->html_instructions;
			$temp         = explode( '<div style="font-size:0.9em">',
				$instructions );

			$new_instructions = new stdClass();
			$new_instructions->text
			                  = html_entity_decode( strip_tags( $temp[0] ) );
			if ( isset( $temp[1] ) ) {
				$new_instructions->info
					= html_entity_decode( strip_tags( $temp[1] ) );
			} else {
				$new_instructions->info = '';
			}
			$new_step->instructions = $new_instructions;

			array_push( $new_steps, $new_step );
		}

		return $new_steps;
	}

	/**
	 * Get infomation Road map
	 *
	 * @return null|stdClass
	 */
	public function getInfoRoadMap() {
		if ( ! $this->getStatus() ) {
			return null;
		}

		$roadMap           = new stdClass();
		$roadMap->summary  = $this->getRoutes()->summary;
		$roadMap->distance = $this->getDistance();
		$roadMap->duration = $this->getDuration();

		return $roadMap;
	}

	private function setOutput() {
		$this->response              = new stdClass();
		$this->response->origin      = $this->getAddressOrigin();
		$this->response->destination = $this->getAddressDestination();
		$this->response->steps       = $this->getStepByStep();
		$this->response->info        = $this->getInfoRoadMap();
	}

	public function getOutput() {
		return $this->response;
	}
}