<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrafficTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'traffic', function ( Blueprint $table ) {
			$table->increments( 'id' );

			$table->string( 'type' );// 'open' | 'congestion'
			$table->string( 'name' );
			$table->string('city');
			$table->double( 'latitude' );
			$table->double( 'longitude' );
			$table->string( 'address_formatted' );
			$table->string( 'place_id' );
			$table->integer( 'time_report' ); // Timestamp

			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop( 'traffic' );
	}
}
