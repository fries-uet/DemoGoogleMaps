<?php

namespace App\Http\Controllers;

use App\Helpers\FriesChat;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests;

class QuestionController extends Controller {
	const TAG_FIND_ROAD = 'abcdxyz';
	const TAG_NOTIFICATION_CONGESTION = 'congestion';
	const TAG_NOTIFICATION_OPEN = 'open';
	const TAG_MY_LOCATION = 'mylocation';
	const TAG_QUESTION_TRAFFIC = 'questiontraffic';
	const TAG_NO_ANSWER = 'noanswer';

	private $TAG_FIND_LOCATION
		= [
			'gas_station' => [
				'cây xăng',
				'trạm xăng',
			],
			'hospital'    => [
				'bệnh viện',
				'trạm xá',
				'trạm y tế',
			]
		];

	/**
	 * Get key type location in string
	 *
	 * @param $str
	 *
	 * @return bool|string
	 */
	public function indexOfLocation( $str ) {
		$str         = mb_strtolower( $str );
		$arrLocation = $this->TAG_FIND_LOCATION;

		foreach ( $arrLocation as $index => $location ) {
			foreach ( $location as $i => $l ) {
				if ( strpos( $str, $l ) !== false ) {
					return $index;
				}
			}
		}

		return false;
	}

	/**
	 * Get answer from client and solve
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAnswer( Request $request ) {
		onlyAllowPostRequest( $request );
		$question     = $request->input( 'question' );
		$my_latitude  = $request->input( 'my_latitude' );
		$my_longitude = $request->input( 'my_longitude' );
		$my_city      = $request->input( 'city' );
		$chat_bot     = new FriesChat( $question );
		if ( $chat_bot->getBotID() == false ) {
			return getResponseError( 'ERROR', 'Haven\'t set bot chat yet' );
		}
		if ( $chat_bot->getStatus() ) {
			Question::store( $chat_bot->getQuestion(), $chat_bot->getAnswer() );
		}

		return $this->parseAnswerBot( $chat_bot->getQuestion(),
			$chat_bot->getAnswer(), $my_latitude,
			$my_longitude, $my_city );
	}

	/**
	 * Solve answer
	 *
	 * @param $question
	 * @param $answer
	 * @param $my_latitude
	 * @param $my_longitude
	 * @param $my_city
	 *
	 * @return \Illuminate\Http\JsonResponse|null
	 */
	public function parseAnswerBot(
		$question, $answer, $my_latitude, $my_longitude, $my_city
	) {
		if ( strpos( mb_strtolower( $question ), 'giá xăng' ) !== false ) {
			$test = new TestController();

			return $test->getPriceGas( $question );
		}
		/**
		 * Direction
		 */
		if ( strpos( $answer, self::TAG_FIND_ROAD ) === 0 ) {
			$args      = explode( self::TAG_FIND_ROAD, $answer )[1];
			$args      = explode( ' , ', $args );
			$direction = new DirectionController();

			if ( strpos( mb_strtolower( $args[0] ), 'đây' ) === 0 ) {
				if ( count( $args ) === 3 ) {
					/**
					 * Find location by type
					 */
					if ( $this->indexOfLocation( $answer ) !== false ) {
						$type_location = $this->indexOfLocation( $args[2] );

						return $direction->byWayType( $my_latitude,
							$my_longitude,
							providerQuerySearch( $args[1], $my_city ),
							$type_location );
					}

					return $direction->byMixed( $my_latitude, $my_longitude,
						providerQuerySearch( $args[1], $my_city ),
						providerQuerySearch( $args[2], $my_city ) );
				}

				/**
				 * Find location by type
				 */
				if ( $this->indexOfLocation( $answer ) !== false ) {
					$type_location = $this->indexOfLocation( $answer );

					return $direction->byToType( $my_latitude, $my_longitude,
						$type_location );
				}

				return $direction->byMixed( $my_latitude, $my_longitude,
					providerQuerySearch( $args[1], $my_city ) );
			} else {
				return $direction->byText( providerQuerySearch( $args[0],
					$my_city ), providerQuerySearch( $args[1], $my_city ) );
			}
		}

		/**
		 * My location
		 */
		if ( strpos( $answer, self::TAG_MY_LOCATION ) === 0 ) {
			$location = new LocationController();

			return $location->byCoordinates( $my_latitude,
				$my_longitude );
		}

		/**
		 * Traffic congestion
		 */
		if ( strpos( $answer, self::TAG_NOTIFICATION_CONGESTION ) === 0 ) {
			$traffic = new TrafficController();

			return $traffic->postStatus( 'congestion', $my_latitude,
				$my_longitude );
		}

		/**
		 * Post Traffic open
		 */
		if ( strpos( $answer, self::TAG_NOTIFICATION_OPEN ) === 0 ) {
			$traffic = new TrafficController();

			return $traffic->postStatus( 'open', $my_latitude,
				$my_longitude );
		}

		/**
		 * Get Traffic
		 */
		if ( strpos( $answer, self::TAG_QUESTION_TRAFFIC ) === 0 ) {
			$traffic = new TrafficController();
			$street  = explode( self::TAG_QUESTION_TRAFFIC, $answer )[1];

			return $traffic->getStatusTrafficByStreet( $street );
		}

		return $this->getResponseSpeak( $question, $answer );
	}

	/**
	 * Get response speak
	 *
	 * @param $question
	 * @param $answer
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getResponseSpeak( $question, $answer ) {
		if ( strpos( $answer, self::TAG_NO_ANSWER ) === 0 ) {
			$answer = explode( self::TAG_NO_ANSWER, $answer )[1];
		}

		return response()->json( [
			'status'   => 'OK',
			'type'     => 'speak',
			'question' => $question,
			'answer'   => $answer
		] );
	}
}
