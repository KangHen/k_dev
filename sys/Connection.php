<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Connection
 * Created by Kang Hen
 * Dec 2016
 */

class Connection{

	/*construct return to db() function*/
	function __construct(){
		return $this->db();
	}

	/*function db*/
	function db(){
		global $db;
		$connect = mysql_connect($db['host'], $db['user'], $db['password']);
		if($connect){
			$selectdb = mysql_select_db($db['database']);
			if(! $selectdb){
				echo 'Error select db';
			}
			//echo 'connection success';
		}else{
			echo 'Connection error';
		}
	}

	/* close connection */
	function close(){
		return mysql_close();
	}
}