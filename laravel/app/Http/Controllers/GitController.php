<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GitController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}

	public function push() {
		$path_log_txt     = '/home/git/maps-service/laravel/public/github.txt';
		$path_git_pull_sh = '/home/git/webhook/git-puller.sh';

		$output = shell_exec( $path_git_pull_sh );

		$server = $_SERVER;
		if ( isset( $server['HTTP_X_GITHUB_EVENT'] )
		     && $server['HTTP_X_GITHUB_EVENT'] == 'push'
		) {
			$content = file_get_contents( 'php://input' );
			$obj     = json_decode( $content );

			$ref               = $obj->ref;
			$request_timestamp = intval( $server['REQUEST_TIME'] );
			$time              = date_create()
				->setTimestamp( $request_timestamp )->format( 'H:i:s d/m/Y' );

			$reponse = $time . ' ' . $ref . PHP_EOL;

			$commits = $obj->commits;
			foreach ( $commits as $index => $commit ) {
				$text = $commit->author->name . '(' . $commit->author->username
				        . ') - ';
				$text .= '"' . $commit->message . '" - ' . $commit->id;

				$reponse .= $text . PHP_EOL;
			}

			$reponse .= '---------------------------------------------------'
			            . PHP_EOL;

			printf( $reponse );

			if ( $this->countLineTextFile( $path_log_txt ) > 1000 ) {
				file_put_contents( $path_log_txt, PHP_EOL . sprintf( $reponse ),
					FILE_TEXT );
			} else {
				file_put_contents( $path_log_txt, PHP_EOL . sprintf( $reponse ),
					FILE_APPEND );
			}
		}


	}

	public function countLineTextFile( $path ) {
		$count  = 0;
		$handle = fopen( $path, 'r' );
		while ( ! feof( $handle ) ) {
			$line = fgets( $handle );
			$count ++;
		}

		fclose( $handle );

		return $count;
	}
}
