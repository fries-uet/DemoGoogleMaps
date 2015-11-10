<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/10/2015
 * Time: 10:55 PM
 */

namespace App\Helpers\Maps;

use App\Helpers\PolylineEncoder;
use \stdClass;

require_once __DIR__ . '/helpers/file-get-contents/file-get-contents.php';
require_once __DIR__ . '/helpers/PolylineEncoder.php';
require_once __DIR__ . '/location-search.php';

class FriesMaps {
	var $KEY_API = 'AIzaSyAQqAhtKKrRusAAtnRkFW6Jd-zs8oKh23c';
	var $response_API;
	var $response_Object_API;
	var $url_api;

	var $origin;
	var $destination;
	var $way_point = null;

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
	 * Type query
	 *
	 * @var string
	 */
	var $type;

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
		$this->KEY_API     = getGoogleMapsKeyAPI();
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
	 * @param array  $way_point
	 *
	 * @return FriesMaps
	 */
	public static function constructWithText(
		$origin, $destination, $mode = 'driving', $way_point = null
	) {
		$instance = new self( $origin, $destination, $mode );
		$instance->setType( 'direction' );

		if ( count( $way_point ) > 0 ) {
			$str_temp = $way_point[0];
			for ( $i = 1; $i < count( $way_point ); $i ++ ) {
				$str_temp .= '|' . $way_point[ $i ];
			}
			$instance->way_point = $str_temp;
		}

		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * @param array  $origin      : lat, lng
	 * @param array  $destination : lat, lng
	 * @param string $mode
	 *
	 * @return FriesMaps
	 */
	public static function constructWithCoordinates(
		$origin, $destination, $mode = 'driving'
	) {
		$origin_text      = $origin['lat'] . ',' . $origin['lng'];
		$destination_text = $destination['lat'] . ', ' . $destination['lng'];

		$instance = new self( $origin_text, $destination_text, $mode );
		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * Contruction with place id
	 *
	 * @param        $origin
	 * @param        $destination
	 * @param string $type
	 * @param string $mode
	 * @param array  $way_point
	 *
	 * @return FriesMaps
	 */
	public static function constructWithPlaceID(
		$origin, $destination, $way_point = null, $type = 'direction',
		$mode = 'driving'
	) {
		$instance
			= new self( $origin, $destination, $mode );
		$instance->setType( $type );
		$instance->origin
			= 'place_id:' . $origin;
		$instance->destination
			= 'place_id:' . $destination;

		if ( count( $way_point ) > 0 ) {
			$str_temp = 'place_id:' . $way_point[0];
			for ( $i = 1; $i < count( $way_point ); $i ++ ) {
				$str_temp .= '|' . 'place_id:' . $way_point[ $i ];
			}
			$instance->way_point = $str_temp;
		}
		$instance->handleResponseAPI();

		return $instance;
	}

	/**
	 * Get content response from Google Maps web service
	 *
	 * @return mixed
	 */
	private function getContentAPI() {
		$this->url_api = sprintf(
			'https://maps.googleapis.com/maps/api/directions/json?origin=%s&destination=%s&key=%s&language=%s&mode=%s&region=%s',
			urlencode( $this->origin ), urlencode( $this->destination ),
			$this->KEY_API, $this->language, $this->mode,
			$this->region
		);

		if ( $this->way_point !== null ) {
			$this->url_api .= '&waypoints=' . urlencode( $this->way_point );
		}

		$content = fries_file_get_contents( $this->url_api );

		return $content;
	}

	/**
	 * Handle response from API
	 */
	private function handleResponseAPI() {
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

	public function setType(
		$type
	) {
		$this->type = $type;
	}

	/**
	 * Get Geometry coding
	 *
	 * @param int $index
	 *
	 * @return mixed
	 */
	public function getGeoCoded(
		$index = 0
	) {
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
	public function getGeoCodedStatus(
		$index = 0
	) {
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

		return $routes->legs;
	}

	/**
	 * Get max index legs
	 *
	 * @return int|null
	 */
	public function getMaxIndexLeg() {
		if ( ! $this->getStatus() ) {
			return null;
		}

		return count( $this->getLegs() ) - 1;
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

		$sum_distance = 0;
		foreach ( $legs as $index => $leg ) {
			$sum_distance += intval( $leg->distance->value );
		}

		if ( $text === true ) {
			if ( $sum_distance < 1000 ) {
				return $sum_distance . ' m';
			}

			$str = '';
			$str .= intval( $sum_distance / 1000 );
			if ( $sum_distance % 1000 > 100 ) {
				$str .= '.'
				        . floor( ( $sum_distance % 1000 ) / 100 );
			}
			$str .= ' km';

			return $str;
		}

		return $sum_distance;
	}

	/**
	 * Get distance text Vietnamese
	 *
	 * @return string
	 */
	public function getDistanceTextVietnamese() {
		$distance = intval( $this->getDistance() );

		if ( $distance < 1000 ) {
			return $distance . ' mét';
		}

		$str = '';
		$str .= intval( $distance / 1000 );
		if ( $distance % 1000 > 100 ) {
			$str .= ' phẩy '
			        . floor( ( $distance % 1000 ) / 100 );
		}
		$str .= ' ki lô mét';

		return $str;
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

		$sum_duration = 0;
		foreach ( $legs as $index => $leg ) {
			$sum_duration += intval( $leg->duration->value );
		}

		if ( $text === true ) {
			$sum_duration_text = round( $sum_duration / 60, 0 ) . ' phút';

			return $sum_duration_text;
		}

		return $sum_duration;
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
		$legs = $this->getLegs()[0];

		return $legs->start_address;
	}

	public function getShortAdressOrigin() {
		$start_address = $this->getAddressOrigin();
		$arr           = explode( ',', $start_address );
		$short_address = $arr[0];

		return $short_address;
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
		$legs = $this->getLegs()[ $this->getMaxIndexLeg() ];

		return $legs->end_address;
	}

	public function getShortAdressDestination() {
		$end_address   = $this->getAddressDestination();
		$arr           = explode( ',', $end_address );
		$short_address = $arr[0];

		return $short_address;
	}

	/**
	 * Get Geocode origin
	 *
	 * @return null|object
	 */
	public function getGeocoderOrigin() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs()[0];

		return $legs->start_location;
	}

	/**
	 * Get Geocode destination
	 *
	 * @return null|object
	 */
	public function getGeocoderDestination() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$legs = $this->getLegs()[ $this->getMaxIndexLeg() ];

		return $legs->end_location;
	}

	/**
	 * Get details origin
	 *
	 * @return stdClass
	 */
	public function getDetailsOrigin() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$origin             = new stdClass();
		$origin->short_name = $this->getShortAdressOrigin();
		$origin->long_name  = $this->getAddressOrigin();
		$origin->geo        = $this->getGeocoderOrigin();

		return $origin;
	}

	/**
	 * Get details destination
	 *
	 * @return stdClass
	 */
	public function getDetailsDestination() {
		if ( ! $this->getStatus() ) {
			return null;
		}
		$destination             = new stdClass();
		$destination->short_name = $this->getShortAdressDestination();
		$destination->long_name  = $this->getAddressDestination();
		$destination->geo        = $this->getGeocoderDestination();

		return $destination;
	}

	public function getDetailsWayPoints() {
		if ( ! $this->getStatus() ) {
			return null;
		}

		$legs       = $this->getLegs();
		$way_points = [ ];
		if ( $this->getMaxIndexLeg() > 0 ) {
			$leg_temp               = $legs[0];
			$point_temp             = new stdClass();
			$point_temp->long_name  = $leg_temp->end_address;
			$point_temp->short_name = explode( ',', $point_temp->long_name )[0];
			$point_temp->geo        = $leg_temp->end_location;
			array_push( $way_points, $point_temp );

			for ( $i = 1; $i < $this->getMaxIndexLeg() - 1; $i ++ ) {
				$leg_temp               = $legs[ $i ];
				$point_temp             = new stdClass();
				$point_temp->long_name  = $leg_temp->end_address;
				$point_temp->short_name = explode( ',',
					$point_temp->long_name )[0];
				$point_temp->geo        = $leg_temp->end_location;
				array_push( $way_points, $point_temp );
			}
		}

		return $way_points;
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

		$steps = [ ];
		foreach ( $legs as $leg ) {
			$steps = array_merge( $steps, $leg->steps );
		}

		return $steps;
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

	private function handleSteps( $steps ) {
		$new_steps = array();
		foreach ( $steps as $index => $step ) {
			$new_step           = new stdClass();
			$new_step->distance = $step->distance->text;
			$new_step->duration = $step->duration->text;
			$new_step->polyline
			                    = PolylineEncoder::decodeValue( $step->polyline->points );

			/**
			 * Maneuver
			 */
			if ( ! isset( $step->maneuver ) ) {
				if ( $index == 0 ) {
					$new_step->maneuver = 'start';
				} else {
					$new_step->maneuver = 'straight';
				}
			} else {
				$new_step->maneuver = $step->maneuver;
			}

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
	 * Get step by step
	 */
	public function getStepByStep() {
		if ( ! $this->getStatus() ) {
			return null;
		}

		$steps     = $this->getSteps();
		$new_steps = $this->handleSteps( $steps );

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

		$roadMap              = new stdClass();
		$roadMap->summary     = $this->getRoutes()->summary;
		$roadMap->distance    = $this->getDistance( true );
		$roadMap->distance_vn = $this->getDistanceTextVietnamese();
		$roadMap->duration    = $this->getDuration( true );

		return $roadMap;
	}

	/**
	 * Set response
	 */
	private function setOutput() {
		$this->response = new stdClass();

		if ( ! $this->getStatus() ) {
			$this->response->status = 'NOT_FOUND';

			return;
		}
		$this->response->status      = 'OK';
		$this->response->type        = $this->type;
		$this->response->info        = $this->getInfoRoadMap();
		$this->response->origin      = $this->getDetailsOrigin();
		$this->response->destination = $this->getDetailsDestination();
		$this->response->waypoints   = $this->getDetailsWayPoints();
		$this->response->steps       = $this->getStepByStep();
	}

	/**
	 * Get response
	 *
	 * @return object
	 */
	public function getOutput() {
		return $this->response;
	}
}