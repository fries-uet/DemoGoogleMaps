<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {
	protected $table = 'locations';

	protected $fillable
		= [
			'type',
			'latitude',
			'longitude',
			'name',
			'address',
			'place_id',
		];
}
