<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 19/10/2015
 * Time: 12:44 AM
 */
class View {
	private $controller;
	private $model;

	public function __construct( $controller, $model ) {
		$this->controller = $controller;
		$this->model      = $model;
	}

	public function output() {
		return '<p><a href="index.php?action=clicked">' . $this->model->string
		       . '</a></p>';
	}
}