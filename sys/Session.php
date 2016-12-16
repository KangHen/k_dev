<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Session
 * Created By Kang Hen
 * Dec 2016
 */

class Session{

	/* create and save data session to the data */
	public $data = array();

	/* create key session */
	public $session_key = array();

	/* start session */
	function __construct(){
		session_start();
	}

	/*
	 * set()
	 * set session name & value
	 */
	function set($name, $value){
		$this->data = array_merge($this->data, array($name => $value));
		$_SESSION['data'] = $this->data;

		return $_SESSION['data'];
	}

	/*
	 * register()
	 * set register if access was accept and verification
	 */
	function register(){
		$datetime = date('ymd').date('his').base64_encode(getcurrenturl());
	}

	/*
	 * get()
	 * get session data with name
	 */
	function get($name){
		return $_SESSION['data'][$name];
	}

	/*
	 * getAlldata()
	 * get all data session
	 */
	function getAlldata(){
		return $_SESSION['data'];
	}
	
	/*
	 * clear()
	 * clear session data
	 */
	function clear(){
		return session_destroy();
	}

	/*
	 * forget()
	 * unset current session
	 */
	function forget($name = null){
		$unset = ($name <> null) ? true : null;
		if($unset == true){
			unset($_SESSION['data'][$name]);
		}
	}
}