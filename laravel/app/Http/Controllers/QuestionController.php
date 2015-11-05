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
		$chat_bot     = new FriesChat( $question );
		if ( $chat_bot->getStatus() ) {
			Question::store( $chat_bot->getQuestion(), $chat_bot->getAnswer() );
		}

		return $this->parseAnswerBot( $chat_bot->getAnswer(), $my_latitude,
			$my_longitude );
	}

	public function parseAnswerBot( $answer, $my_latitude, $my_longitude ) {
		// Direction
		if ( strpos( $answer, self::TAG_FIND_ROAD ) === 0 ) {
			$args      = explode( self::TAG_FIND_ROAD, $answer )[1];
			$args      = explode( ' , ', $args );
			$direction = new DirectionController();

			if ( strpos( $args[0], 'Đây' ) === 0 ) {
				return $direction->byMixed( $my_latitude, $my_longitude,
					$args[1] );
			} else {
				return $direction->byText( $args[0], $args[1] );
			}
		}

		// My location
		if ( strpos( $answer, self::TAG_MY_LOCATION ) === 0 ) {
			$location = new LocationController();

			return $location->byCoordinates( $my_latitude,
				$my_longitude );
		}

		// Traffic congestion
		if ( strpos( $answer, self::TAG_NOTIFICATION_CONGESTION ) === 0 ) {
			$traffic = new TrafficController();

			return $traffic->postStatus( 'congestion', $my_latitude,
				$my_longitude );
		}

		// Post Traffic open
		if ( strpos( $answer, self::TAG_NOTIFICATION_OPEN ) === 0 ) {
			$traffic = new TrafficController();

			return $traffic->postStatus( 'open', $my_latitude,
				$my_longitude );
		}

		// Get Traffic
		if ( strpos( $answer, self::TAG_QUESTION_TRAFFIC ) === 0 ) {
			$traffic = new TrafficController();
			$street  = explode( self::TAG_QUESTION_TRAFFIC, $answer )[1];

			return $traffic->getStatusTrafficByStreet( $street );
		}

		return getResponseError();
	}

	public function getAllQuestion() {
		$questions = Question::getAll();

		return response()->json( [
			'status' => 'OK',
			'data'   => $questions,
		] );
	}

	public function webGetAll() {
		$questions = Question::getAll();

		return view( 'bot' )->with( 'questions', $questions );
	}
}