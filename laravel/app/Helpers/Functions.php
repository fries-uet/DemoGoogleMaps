<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 22/10/2015
 * Time: 5:35 PM
 */

namespace App\Helpers;

function responseError() {
	echo json_encode( [ 'status' => 'ERROR' ] );
}