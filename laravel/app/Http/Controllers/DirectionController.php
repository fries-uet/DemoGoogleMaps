<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\Maps;

class DirectionController extends Controller {
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

	/**
	 * Direction by Text query
	 *
	 * @param $origin
	 * @param $destination
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byText( $origin, $destination ) {
		$direction = Maps\FriesMaps::constructWithText( $origin, $destination );

		return response()->json( $direction->getOutput() );
	}

	/**
	 * Direction by place_id
	 *
	 * @param $origin
	 * @param $destination
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function byPlaceID( $origin, $destination ) {
		$direction = Maps\FriesMaps::constructWithPlaceID( $origin,
			$destination );

		return response()->json( $direction->getOutput() );
	}
}
