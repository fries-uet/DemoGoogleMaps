<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DocumentController extends Controller {
	public function bot() {
		return view( 'docs.bot' );
	}
}
