<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 04/11/2015
 * Time: 11:19 PM
 */

namespace App\Helpers;

use App\Bot;
use stdClass;

class FriesChat {
	private $botid;
	private $token;
	private $url_api;
	private $url_api_bots;

	public $content_API = '';
	public $object_API;
	public $content_API_bots;
	public $object_API_bots;

	public $bots = [ ];

	public $question;
	public $answer;

	public $output;

	/**
	 * @var bool $status
	 */
	public $status;

	/**
	 * Construction by question
	 *
	 * @param $question
	 */
	public function __construct( $question = '' ) {
		try {
			$bot_model = Bot::all();
			if ( $bot_model->count() > 0 ) {
				$this->botid = $bot_model->first()->value( 'bot_id' );
			} else {
				$this->botid = false;
			}
		} catch ( \PDOException $exception ) {
			$this->botid = false;
		}

		$this->token = '775ced42-8100-48ef-add1-a7cc6be261ab';

		$this->getAPI( $question );
	}

	/**
	 * Get content from server AIML
	 *
	 * @param $question
	 */
	public function getAPI( $question ) {
		$this->url_api = 'http://118.69.135.27/AIML/bot/chat';

		$body              = [
			'botID'    => $this->botid,
			'question' => $question,
		];
		$this->content_API = fries_post_contents( $this->url_api, null, $body );
		$this->handleAPI();
	}

	/**
	 * Get content bots API
	 */
	public function getAPIBots() {
		$this->url_api_bots
			= sprintf( 'http://118.69.135.27/AIML/api/bots?token=%s',
			$this->token );

		$this->content_API_bots
			= fries_file_get_contents( $this->url_api_bots );
		$this->handleAPIBots();
	}

	/**
	 * Handle get bots API
	 */
	public function handleAPIBots() {
		$this->object_API_bots = json_decode( $this->content_API_bots );
		if ( $this->getStatusBots() ) {
			$this->bots = $this->object_API_bots->bots;
		}
	}

	/**
	 * Get status get bots
	 *
	 * @return bool
	 */
	public function getStatusBots() {
		if ( $this->object_API_bots->result === 'success' ) {
			return true;
		}

		return false;
	}

	/**
	 * Get bots
	 *
	 * @return array
	 */
	public function getBots() {
		return $this->bots;
	}

	/**
	 * Handle api response
	 */
	public function handleAPI() {
		$this->object_API = json_decode( $this->content_API );
		$this->setStatus();
		$this->setAnswer();
		$this->setQuestion();
		$this->setOutput();
	}

	/**
	 * @return string
	 */
	public function getResponseContent() {
		return $this->content_API;
	}

	/**
	 * @return object
	 */
	public function getResponseObject() {
		return $this->object_API;
	}

	/**
	 * Set status answer
	 */
	private function setStatus() {
		$obj = $this->getResponseObject();
		if ( property_exists( $obj, 'status' ) ) {
			if ( $obj->status === 'success' ) {
				$this->status = true;
			} else {
				$this->status = false;
			}
		} else {
			$this->status = false;
		}
	}

	/**
	 * Get status answer
	 *
	 * @return bool
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Set Answer
	 */
	public function setAnswer() {
		$obj = $this->getResponseObject();
		if ( property_exists( $obj, 'bot' ) ) {
			$this->answer = $obj->bot;
		}
	}

	/**
	 * Get answer
	 *
	 * @return mixed
	 */
	public function getAnswer() {
		return $this->answer;
	}

	/**
	 * Set Question
	 */
	public function setQuestion() {
		$obj = $this->getResponseObject();
		if ( property_exists( $obj, 'human' ) ) {
			$this->question = $obj->human;
		}
	}

	/**
	 * Get Question
	 *
	 * @return mixed
	 */
	public function getQuestion() {
		return $this->question;
	}

	private function setOutput() {
		$response = new stdClass();
		if ( $this->getStatus() ) {
			$response->status = 'OK';
		} else {
			$response->status = 'ERROR';
		}

		$response->answer   = $this->getAnswer();
		$response->question = $this->getQuestion();
		$response->type     = 'bot_chat';

		$this->output = $response;
	}

	public function getOutput() {
		return $this->output;
	}

	public function getBotID() {
		return $this->botid;
	}

	public function getToken() {
		return $this->token;
	}

}