<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 04/11/2015
 * Time: 11:19 PM
 */

namespace App\Helpers;

class FriesChat {
	private $botid;
	private $token;
	private $url_api;
	private $url_api_bots;

	public $content_API = '';
	public $object_API;
	public $content_API_bots;

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
		$this->botid = '5633a9c7e4b07d327ad8794b';
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

	public function getAPIBots() {
		$this->url_api_bots
			= sprintf( 'http://118.69.135.27/AIML/api/bots?token=%s',
			$this->token );

		$this->content_API_bots
			= fries_file_get_contents( $this->url_api_bots );
		$this->handleAPIBots();
	}

	public function handleAPIBots() {
		$obj = json_decode( $this->content_API_bots );
		if ( $obj->result === 'success' ) {
			$this->bots = $obj->bots;
		}
	}

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
		$response = new \stdClass();
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