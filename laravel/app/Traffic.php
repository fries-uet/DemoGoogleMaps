<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model {
	protected $table = 'traffic';

	protected $fillable
		= [
			'type',
			'name',
			'status_text',
			'latitude',
			'longitude',
			'address_formatted',
			'address_html',
			'place_id',
			'time_report',
		];

	public static function getStatusTrafficAll( $type = null ) {
		try {
			if ( $type != null ) {
				$traffic = self::all()->where( 'type', $type );
			} else {
				$traffic = self::all();
			}
		} catch ( \PDOException $excetion ) {
			$traffic = null;
		}

		return $traffic;
	}

	/**
	 * Get list status traffic by type and time report
	 *
	 * @param null|string $type : 'open', 'congestion'
	 * @param int         $time
	 *
	 * @return array
	 */
	public static function getStatusTraffic( $type = null, $time = 86400 ) {
		if ( $type == null ) {
			$all_traffic = self::getStatusTrafficAll();
		} else {
			$all_traffic = self::getStatusTrafficAll( $type );
		}

		$traffic_custom = array();
		$timestamp_now  = date_create()->getTimestamp();
		if ( count( $all_traffic ) > 0 ) {
			foreach ( $all_traffic as $index => $traffic ) {
				$timestamp = $traffic->value( 'time_report' );
				if ( $timestamp_now - $timestamp < $time ) {
					array_push( $traffic_custom, $traffic );
				}
			}
		}

		return $traffic_custom;
	}

	/**
	 * Get list status traffic daily
	 *
	 * @param null|string $type : 'open', 'congestion'
	 *
	 * @return array
	 */
	public static function getStatusTrafficDaily( $type = null ) {
		$daily_traffic = self::getStatusTraffic( $type );

		return $daily_traffic;
	}
}
