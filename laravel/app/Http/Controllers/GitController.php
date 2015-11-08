<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class GitController extends Controller {
	/**
	 * Handle event git push
	 */
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
				->setTimestamp( $request_timestamp )
				->setTimezone( new \DateTimeZone( 'Asia/Ho_Chi_Minh' ) )
				->format( 'H:i:s d/m/Y' );

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

	/**
	 * Count line text file
	 *
	 * @param $path
	 *
	 * @return int
	 */
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
