<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 19/10/2015
 * Time: 12:44 AM
 */
class Model {
	public $string;

	public function __construct() {
		$this->string = 'SMAC Challenge';
	}

	public function setString( $string ) {
		$this->string = $string;
	}
}