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

	public static function getStatusTraffic() {
		$traffic = Traffic::all();

		return $traffic;
	}
}
