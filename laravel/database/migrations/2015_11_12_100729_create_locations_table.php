<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'locations', function ( Blueprint $table ) {
			$table->increments( 'id' );

			$table->string( 'type' );
			$table->double( 'latitude' );
			$table->double( 'longitude' );
			$table->string( 'name' );
			$table->string('address');
			$table->string('place_id');

			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop( 'locations' );
	}
}
