<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 19/10/2015
 * Time: 12:44 AM
 */
class Controller {
	private $model;
	private $view;

	public function __construct( $model ) {
		$this->model = $model;
		$this->view  = new View( $this, $this->model );
	}

	public function clicked( $args = array() ) {
		$this->model->string = 'Updated data! Have fun :]';
		print_r( $args );
	}

	public
	function getError() {
		die( ':((' );
	}

	public function action( $uri ) {
		parse_str( $uri, $args );
		if ( method_exists( $this, $args['action'] ) ) {
			$this->{$args['action']}( $args );
		} else {
			$this->getError();
		}

	}
}