<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Hash
 * Created By Kang Hen
 * Dec 2016
 */

class Hash{
	
	/*salt*/
	//static $salt = ;

	public static function make($str)
	{
		//$hash = self::xyz().crypt($str).self::$salt;
		//return $hash;
	}

	public static function verify($str,$hash)
	{
		//substr(string, 0,19);
	}

	public static function xyz(){
		//strrandom(10)
	}
}