<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers;
use App\Helpers\Maps\FriesLocationSearch;
use App\Helpers\Maps\FriesLocationDetails;

use App\Traffic;
use DB;
use Mockery\CountValidator\Exception;

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

//					return response()->json( $locationDetail->getStreetName() );

						if ( $locationDetail->getStreetName() == null ) {
							Helpers\responseError();
						}

						$street_name     = $locationDetail->getStreetName();
						$location_report = [
							'type'              => $type,
							'name'              => $street_name,
							'latitude'          => $locationDetail->getLatitude(),
							'longitude'         => $locationDetail->getLongitude(),
							'address_formatted' => $locationDetail->getAddressFormatted(),
							'address_html'      => $locationDetail->getAddressHTML(),
							'place_id'          => $locationDetail->getPlaceID(),
							'time_report'       => date_create()->getTimestamp(),
						];

						$model = DB::table( 'traffic' )
						           ->where( 'name', $street_name );

						if ( $model->count() > 0 ) {
							$id = $model->value( 'id' );
							$model->update( $location_report );
						} else {
							// Insert & get ID
							$id = DB::table( 'traffic' )
							        ->insertGetId( $location_report );
						}

						// Set id
						$location_report['id'] = $id;

						return response()->json( [
							'status' => 'SUCCESS',
							'data'   => $location_report,
						] );


					} else {
						Helpers\responseError();
					}
				} else {
					Helpers\responseError();
				}
			} else {
				Helpers\responseError();
			}
		} catch ( \PDOException $exception ) {
			Helpers\responseError();
		}

		return null;
	}

	public function getStatus() {
		try {
			$traffic = Traffic::getStatusTraffic();
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
				if ( $timestamp_ago > 86400 ) {
					unset( $traffic[ $index ] );
				}

				$a['ago']
					= Helpers\convertCountTimestamp2String( $timestamp_ago );
			}

			$traffics = array();
			foreach ( $traffic as $index => $a ) {
				array_push( $traffics, $a );
			}

			return response()->json( [
				'status' => 'OK',
				'data'   => $traffics,
			] );
		} catch ( \PDOException $exception ) {
			Helpers\responseError();
		}

		return null;
	}

	public function getStatusByType( $type ) {
		if ( $type != 'open' && $type != 'congestion' ) {
			Helpers\responseError();

			return null;
		}
		try {
			$traffic = Traffic::getStatusTraffic( $type );

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
				if ( $timestamp_ago > 86400 ) {
					unset( $traffic[ $index ] );
				}

				$a['ago']
					= Helpers\convertCountTimestamp2String( $timestamp_ago );

			}

			$traffics = array();
			foreach ( $traffic as $index => $a ) {
				array_push( $traffics, $a );
			}

			return response()->json( [
				'status' => 'OK',
				'data'   => $traffics,
			] );
		} catch ( \PDOException $exception ) {
			Helpers\responseError();
		}

		return null;
	}
}
