<?php

namespace App\Http\Controllers;

use App\Helpers\Maps\FriesLocationSearch;
use App\Helpers\Maps\FriesMaps;
use App\Helpers\PolylineEncoder;
use Illuminate\Http\Request;
use App\Http\Requests;

class TestController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}

	public function test( $query ) {
		$location
			= FriesLocationSearch::constructWithText( $query );

//		print_r( $location->getResults() );


		$polyline
			= PolylineEncoder::decodeValue( 'iam_CenndSZeA@C?AF[nA{EtBcINm@pAeF^gAv@aDNg@hCsKz@aDhDgP' );

		print_r( $polyline );
	}
}
