<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Location;

class TestController extends Controller {
	public function test() {
//		$hospital = [
//			'ChIJjzVOEXqsNTERZ7rzIjI8Blc',
//			'ChIJ3XbdT_CrNTER301yE92SgLw',
//			'ChIJSZVZ8S6rNTERos-ogweQC7s',
//			'ChIJSei8g5arNTERMNXluR0v-Sw',
//			'ChIJM8ZIZnesNTER6arrqD68DeY',
//			'ChIJQZN-oI2rNTERgoIPjdzzADk',
//			'ChIJIZ1LSoyrNTERlmFBrs_r4Ls',
//			'ChIJv86KYZ2sNTERVryiCVb3y0M',
//			'ChIJiYPYg5arNTERwbaXfU2ZzhE',
//			'ChIJHaTEL5SrNTERkvPJ-R2zYOE',
//			'ChIJYTq31pWrNTEROXmJnU9OyeQ',
//			'ChIJ_VcoXGirNTERlBMamf6Hsds',
//			'ChIJJZOD74KsNTERYnMvzws07Bk',
//			'ChIJowllHRGrNTERsgiEMWO1iag',
//			'ChIJu9R10nirNTER40h8I5cpLOM',
//			'ChIJx23qeAmsNTER7bkA3Zo6EOU',
//			'ChIJuQlSspirNTERIkZKe_SKNBo',
//			'ChIJ7Raoe5OrNTERWsJTMbaiwx0',
//			'ChIJzc3qpz4BNTER1O3ceytYxfs',
//			'ChIJyZPBu8YodTERESdmfhr6y_M',
//			'ChIJ0ev-IHOsNTERsvPMlDUKJ38',
//			'ChIJvzTnuWmrNTERWzwpmzaq9cw',
//			'ChIJKYLrHRGpNTERk274Q1JEtYM',
//			'ChIJOWFCuwusNTERgQB5cKg8NYs',
//			'ChIJhcdEhJSrNTERsh1U92nKR1M',
//			'ChIJGzbiXsKoNTER8Gtkh1mE2us',
//			'ChIJo098LucANTERwjn7PVBznTQ',
//			'ChIJtcw9IrqtNTERebJXLOHnTLc',
//			'ChIJk_d5uBQDNTER2PMGN7x5sZs',
//			'ChIJocPE_EKrNTERmYL8keQHXnc',
//			'ChIJq7SsQ_OtNTERJdZUgUVzzO0',
//			'ChIJIZ1LSoyrNTERlmFBrs_r4Ls',
//			'ChIJIVLbLSitNTERMIcCN97LksU',
//			'ChIJ00-jlXmsNTERGqflb-ak8N4',
//			'ChIJgyIFhEmrNTERBytUg5miXUA',
//			'ChIJrx4J7nmsNTERxC0ag6bCrt0',
//			'ChIJjzVOEXqsNTERZ7rzIjI8Blc',
//			'ChIJJ4AS1vGrNTERRs331bN32ow',
//			'ChIJ_bWXJHqsNTER_ueWQQd7KAk',
//		];

//		foreach ( $hospital as $i => $h ) {
//			$location = new FriesLocationDetails( $h );
//
//			$l = Location::create( [
//				'type'      => 'hospital',
//				'name'      => $location->getName(),
//				'address'   => $location->getAddressFormatted(),
//				'place_id'  => $h,
//				'latitude'  => $location->getLatitude(),
//				'longitude' => $location->getLongitude(),
//			] );
//			var_dump( $l );
//		}


		$hospital = Location::all();

		foreach ( $hospital as $i => $h ) {
			var_dump( $h->name );
		}
	}
}