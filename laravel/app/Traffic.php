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

	public static function getStatusTraffic( $type = null ) {
		try {
			if ( $type != null ) {
				$traffic = Traffic::all()->where( 'type', $type );
			} else {
				$traffic = Traffic::all();
			}
		} catch ( \PDOException $excetion ) {
			$traffic = null;
		}

		return $traffic;
	}

	public static function postStatusTraffic() {

	}
}
