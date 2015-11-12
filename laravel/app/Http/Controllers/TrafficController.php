<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Helpers\Maps\FriesLocationSearch;
use App\Helpers\Maps\FriesLocationDetails;

use App\Traffic;
use Exception;
use Unirest\File;

class TrafficController extends Controller {
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
							'city'              => $locationDetail->getProvinceName(),
							'latitude'          => $locationDetail->getLatitude(),
							'longitude'         => $locationDetail->getLongitude(),
							'address_formatted' => $locationDetail->getAddressFormatted(),
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
							'type'   => 'post_traffic',
						] );
					}
				}
			}
		} catch ( \PDOException $exception ) {
			return getResponseError( 'DISCONNECTED_DATABASE' );
		}

		return getResponseError();
	}

	/**
	 * Get list status traffic
	 *
	 * @return array|null
	 */
	public function getStatus() {
		try {
			$traffic = Traffic::getStatusTraffic( null, 3600 );

			$merge_traffic = array();
			if ( $traffic ) {
				foreach ( $traffic as $index => $a ) {
					//Hide variable unnecessary
					unset( $a['created_at'] );
					unset( $a['updated_at'] );
					unset( $a['updated_at'] );
					unset( $a['place_id'] );
					unset( $a['address_html'] );

					$traffic[ $index ]->address_formatted
						= explode( ', Việt Nam',
						$a->address_formatted )[0];

					$timestamp_ago = date_create()->getTimestamp()
					                 - intval( $a['time_report'] );
					$a['ago']      = $timestamp_ago;
					$a['ago_text']
					               = convertCountTimestamp2String( $timestamp_ago );

					if ( $index == 0 ) {
						array_push( $merge_traffic, $a );
					} else {
						$name = $a['name'];

						$merge = false;
						foreach ( $merge_traffic as $i => $b ) {
							if ( $name == $b['name'] ) {
								$merge_traffic[ $i ] = $a;
								$merge               = true;
							}
						}

						if ( ! $merge ) {
							array_push( $merge_traffic, $a );
						}
					}
				}
			}

			return $merge_traffic;
		} catch ( Exception $e ) {
			$view = getResponseError( 'ERROR', $e->getMessage() );
			$view->send();
			die();
		}
	}

	public function getStatusAll() {
		$traffic = self::getStatus();

		return response()->json( [
			'status' => 'OK',
			'data'   => $traffic,
			'result' => count( $traffic ),
			'type'   => 'get_traffic',
		] );
	}

	public function getStatusTrafficByStreet( $street ) {
		$traffic = self::getStatus();

		if ( count( $traffic ) == 0 ) {
			return response()->json( [
				'status' => 'OK',
				'data'   => null,
				'result' => 0,
				'type'   => 'get_traffic',
			] );
		}

		/**
		 * Test ==
		 *
		 * @var  $index
		 * @var  $t
		 */
		foreach ( $traffic as $index => $t ) {
			if ( strtolower( $t->name ) == strtolower( $street ) ) {
				return response()->json( [
					'status' => 'OK',
					'data'   => $t,
					'result' => 1,
					'type'   => 'get_traffic',
				] );
			}
		}

		/**
		 * Search name
		 */
		$location_search
			= FriesLocationSearch::constructWithText( $street );
		if ( $location_search->countResults() == 0 ) {
			return getResponseError();
		}

		$place_id         = $location_search->getPlaceIDbyIndex();
		$location_details = new FriesLocationDetails( $place_id );
		$street_name      = $location_details->getStreetName();

		foreach ( $traffic as $index => $t ) {
			if ( strtolower( $t->name ) == strtolower( $street_name ) ) {
				return response()->json( [
					'status' => 'OK',
					'data'   => $t,
					'result' => 1,
					'type'   => 'get_traffic',
				] );
			}
		}

		return response()->json( [
			'status' => 'OK',
			'data'   => null,
			'result' => 0,
			'type'   => 'get_traffic',
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
		$traffic = self::getStatus();

		if ( $traffic == null ) {
			return response()->json( [
				'status' => 'OK',
				'data'   => null,
				'result' => 0,
				'type'   => 'get_traffic',
			] );
		}

		$traffic_type = array();
		foreach ( $traffic as $index => $t ) {
			if ( $t->type == $type ) {
				array_push( $traffic_type, $t );
			}
		}

		return response()->json( [
			'status' => 'OK',
			'data'   => $traffic_type,
			'result' => count( $traffic_type ),
			'type'   => 'get_traffic',
		] );
	}

	public function traffic() {
		$traffics = self::getStatus();

		return view( 'traffic.traffic' )->with( 'traffics', $traffics );
	}
}
