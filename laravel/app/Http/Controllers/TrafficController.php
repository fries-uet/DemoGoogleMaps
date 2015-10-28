<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\Maps\FriesLocationSearch;
use App\Helpers\Maps\FriesLocationDetails;

use App\Traffic;

class TrafficController extends Controller {
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
	 * Post status traffic
	 *
	 * @param $type
	 * @param $lat
	 * @param $lng
	 *
	 * @return \Illuminate\Http\JsonResponse|null
	 */
	public function postStatus( $type, $lat, $lng ) {
		try {
			if ( $type == 'congestion' || $type == 'open' ) {
				$locationSearch
					= FriesLocationSearch::constructWithLocation( $lat,
					$lng );

				if ( $locationSearch->getStatus() ) {
					$locationDetail
						= new FriesLocationDetails( $locationSearch->getPlaceIDbyIndex( 0 ) );

					if ( $locationDetail->getStatus() ) {
						if ( $locationDetail->getStreetName() == null ) {
							return getResponseError();
						}

						$location_report = [
							'type'              => $type,
							'name'              => $locationDetail->getStreetName(),
							'latitude'          => $locationDetail->getLatitude(),
							'longitude'         => $locationDetail->getLongitude(),
							'address_formatted' => $locationDetail->getAddressFormatted(),
							'address_html'      => $locationDetail->getAddressHTML(),
							'place_id'          => $locationDetail->getPlaceID(),
							'time_report'       => date_create()->getTimestamp(),
						];

						$id = Traffic::create( $location_report )
						             ->getAttributeValue( 'id' );

						// Set id
						$location_report['id'] = $id;

						return response()->json( [
							'status' => 'OK',
							'data'   => $location_report,
						] );
					}
				}
			}
		} catch ( \PDOException $exception ) {
			return getResponseError();
		}

		return getResponseError();
	}

	/**
	 * Get list status traffic
	 *
	 * @return \Illuminate\Http\JsonResponse|null
	 */
	public function getStatus() {
		$traffic = Traffic::getStatusTraffic();
		if ( $traffic == null ) {
			return getResponseError();
		}

		foreach ( $traffic as $index => $a ) {
			//Hide variable unnecessary
			unset( $a['created_at'] );
			unset( $a['updated_at'] );
			unset( $a['updated_at'] );
			unset( $a['place_id'] );
			unset( $a['address_html'] );

			$timestamp_ago = date_create()->getTimestamp()
			                 - intval( $a['time_report'] );
			$a['ago']
			               = convertCountTimestamp2String( $timestamp_ago );
			// Destroy the traffic was expired
			if ( $timestamp_ago > 21600 ) {
				unset( $traffic[ $index ] );
			}
		}

		$traffics = array();
		foreach ( $traffic as $index => $a ) {
			array_push( $traffics, $a );
		}

		return response()->json( [
			'status' => 'OK',
			'data'   => $traffics,
		] );
	}

	/**
	 * Get list status by type
	 *
	 * @param $type
	 *
	 * @return \Illuminate\Http\JsonResponse|null
	 */
	public function getStatusByType( $type ) {
		if ( $type != 'open' && $type != 'congestion' ) {
			return getResponseError();
		}
		$traffic = Traffic::getStatusTraffic( $type );
		if ( $traffic == null ) {
			return getResponseError();
		}

		foreach ( $traffic as $index => $a ) {
			//Hide variable unnecessary
			unset( $a['created_at'] );
			unset( $a['updated_at'] );
			unset( $a['updated_at'] );
			unset( $a['place_id'] );
			unset( $a['address_html'] );

			$timestamp_ago = date_create()->getTimestamp()
			                 - intval( $a['time_report'] );
			// Destroy the traffic from previous days
			if ( $timestamp_ago > 21600 ) {
				unset( $traffic[ $index ] );
			}

			$a['ago']
				= convertCountTimestamp2String( $timestamp_ago );

		}

		$traffics = array();
		foreach ( $traffic as $index => $a ) {
			array_push( $traffics, $a );
		}

		return response()->json( [
			'status' => 'OK',
			'data'   => $traffics,
		] );
	}
}
