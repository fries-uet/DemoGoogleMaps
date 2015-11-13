<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGaragesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'garages', function ( Blueprint $table ) {
			$table->increments( 'id' );

			$table->string( 'name' );
			$table->string( 'address' );
			$table->string( 'phone_number' );
			$table->string( 'place_id' );

			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop( 'garages' );
	}
}
