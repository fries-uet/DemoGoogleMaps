<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 13/10/2015
 * Time: 10:37 PM
 */

require_once 'unirest/Unirest.php';

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

	function __construct() {
		$this->language = 'vi';
	}

	public static function constructWithText( $query ) {
		$instance        = new self();
		$instance->query = $query;

		$instance->url_API
			= sprintf( 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=%s&key=%s',
			$instance->query, self::KEY_MAPS );

		$instance->handleResponseAPI();

		return $instance;
	}

	public static function constructWithLocation( $lat, $lng, $radius = 500 ) {
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
		$obj_unirest
			     = Unirest\Request::get( $this->url_API, null, null );
		$content = $obj_unirest->raw_body;

		return $content;
	}

	/**
	 * Handle response from API
	 */
	public function handleResponseAPI() {
		$this->response_API        = $this->getContentAPI();
		$this->response_Object_API = json_decode( $this->response_API );
	}

	public function getObjectAPI() {
		return $this->response_Object_API;
	}
}