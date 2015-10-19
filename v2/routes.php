<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 19/10/2015
 * Time: 10:18 AM
 */
class Route {
	public static function get( $controller ) {
		$uri = $_SERVER['QUERY_STRING'];
		if ( method_exists( $controller, 'action' ) ) {
			$controller->action( $uri );
		}
	}
}