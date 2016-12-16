<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Web
 * Created By Kang Hen
 * dec 2016
 */

class Web{

	/*
	 * run()
	 * run the application
	 * return $response->send()
	 */
	static function run(){
		$response = new Response;
		return $response->send();
	}

}