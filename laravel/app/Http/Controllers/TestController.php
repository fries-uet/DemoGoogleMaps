<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Location;
use Exception;
use Illuminate\Http\Request;

class TestController extends Controller {
	public function getPriceGas( $question ) {
		try {
			$prices = getPriceGas();

			$answer = 'giá xăng A 92 là ';
			$answer .= convertPriceToText( $prices['a92'] ) . ', ';
			$answer .= 'A 95 là ';
			$answer .= convertPriceToText( $prices['a95'] );

			return response()->json( [
				'status'   => 'OK',
				'type'     => 'speak',
				'question' => $question,
				'answer'   => $answer
			] );
		} catch ( Exception $e ) {
			$view = getResponseError( 'ERROR', $e->getMessage() );
			$view->send();
			die();
		}
	}

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


//		$hospital = Location::all();
//
//		foreach ( $hospital as $i => $h ) {
//			var_dump( $h->name );
//		}

//		$url_gas = 'http://www.petrolimex.com.vn';
//		$content = fries_file_get_contents( $url_gas );
//
//		$content = explode( 'vie_p3_PortletContent', $content )[1];
//		$content = explode( 'blueseaContainerFooter', $content )[0];
//
//		$a95 = explode( 'Xăng RON 95</a></div><div class="c">', $content )[1];
//		$a95 = explode( '</div>', $a95 )[0];
//
//		$a92 = explode( 'Xăng RON 92</a></div><div class="c">', $content )[1];
//		$a92 = explode( '</div>', $a92 )[0];
//
//		echo convertPriceToText( $a92 );
//		echo '<br>' . convertPriceToText( $a95 );

		return view( 'traffic.maps' );
	}


	public function testGet( $id ) {
		return response()->json( [
			'status' => 'ok',
			'msg'    => 'Content id: ' . $id,
		] );
	}

	public function testPost( Request $request ) {
		$x = $request->input( 'x' );

		return response()->json( [
			'status' => 'ok',
			'msg'    => 'Received: ' . $x,
		] );
	}

	public function genTraffic() {
		$gens = [
			[
				//Ton That Thuyet
				21.028460,
				105.782082,
			],
			[
				//Cau Giay
				21.034628,
				105.794764,

			],
//			[
//				//Ho Tung Mau
//				21.037735,
//				105.773675
//			]
		];

		foreach ( $gens as $i => $g ) {
			$body = [
				'my_latitude'  => $g[0],
				'my_longitude' => $g[1],
				'question'     => 'ở đây đang tắc đường',
				'city'         => 'hà nội',
			];
			$res  = fries_post_contents( url( '/' ) . '/v2/bot/chat', null,
				$body );

			print_r( $res );
		}
	}
}