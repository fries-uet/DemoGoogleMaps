<?php

namespace App\Http\Controllers;

use App\Helpers\FriesChat;
use App\Question;
use Illuminate\Http\Request;

class PageController extends Controller {
	/**
	 * Homepage
	 *
	 * @return \Illuminate\View\View
	 */
	public function home() {
		return view( 'home' );
	}

	public function traffic() {
		abort( 404 );
	}

	/**
	 * Download app
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function downloadBeta() {
		$app = url( '/' ) . '/download/maps-1.0.0.apk';

		return response()->redirectTo( $app );
	}
}
