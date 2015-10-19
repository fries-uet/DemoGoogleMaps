<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 19/10/2015
 * Time: 12:43 AM
 */

require_once 'loader.php';

$model      = new Model();
$controller = new Controller( $model );
$view       = new View( $controller, $model );

if ( isset( $_GET['action'] ) && ! empty( $_GET['action'] ) ) {
	Route::get( $controller );
}

echo $view->output();