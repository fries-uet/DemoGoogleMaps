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

	public $content_API = '';
	public $object_API;

	public $question;
	public $answer;

	/**
	 * @var bool $status
	 */
	public $status;

	/**
	 * Construction by question
	 *
	 * @param $question
	 */
	public function __construct( $question ) {
		$this->botid = '5639640be4b07d327ad88bed';
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
			'botID'    => '5639640be4b07d327ad88bed',
			'question' => $question,
		];
		$this->content_API = fries_post_contents( $this->url_api, null, $body );
		$this->handleAPI();
	}

	/**
	 * Handle api response
	 */
	public function handleAPI() {
		$this->object_API = json_decode( $this->content_API );
		$this->setStatus();
		$this->setAnswer();
		$this->setQuestion();
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

}