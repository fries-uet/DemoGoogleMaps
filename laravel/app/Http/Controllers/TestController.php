<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class TestController extends Controller {
	public function test() {
		$question = new QuestionController();

		$question->indexOfLocation('đây, trạm xăng gần nhất');
	}
}