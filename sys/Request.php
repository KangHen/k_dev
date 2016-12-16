<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Request
 * Created By Kang Hen
 * Dec 2016
 */

class Request{
	/* route pass */
	public $route;

	/* collect post */
	protected $collect_post = array();

	/* define post request */
	//protected $post = $_POST;

	/* define files request */
	//protected $file = $_FILES;

	/* define all request */
	protected $allrequest = array();

	/* save filename */
	protected $filename;

	/* set path */
	protected $setpath = '';

	/* construct with new route */
	function __construct($setpath = null){
		//$this->route = new Route;
		$this->setpath = $setpath;
	}

	/*
	 * post()
	 * get post request
	 * return post with anti injection
	 */
	public function post($request){
		return htmlspecialchars($_POST[$request]);
	}

	/*
	 * get()
	 */
	public function get($request){
		return htmlspecialchars($_REQUEST[$request]);
	}

	/*
	 * file
	 */
	public function file($request){
		return $_FILES[$request];
	}
	/*
	 * getAll()
	 * return all request
	 */
	public function getAll(){
		foreach ($_REQUEST as $key => $value) {
			if(strtolower($key) == 'pass' || strtolower($key) == 'password'){
				$this->allrequest[$key] = base64_encode($value);
			}else{
				$this->allrequest[$key] = $value;
			}
		}
		return $this->allrequest;
	}

	/*
	 * hasFile
	 * return bool
	 */
	public function hasFile($name){
		$has = array_key_exists($name, $_FILES);
		return $has;
	}

	/*
	 * infiles()
	 * $this
	 */
	public function infiles($request){
		$this->filename = $_FILES[$request];
		return $this;
	}

	/* 
	 * is file
	 * check if request is file 
	 * return bool
	 */
	public function isfile($request){
		$in = array_key_exists($request, $_FILES);
		if($in == true){
			return $this->infiles($request);
		}else{
			return $this->_request($request, $_REQUEST);
		}
	}

	/*
	 * getname()
	 * get name of file
	 * return name;
	 */
	public function getname(){
		return $this->filename['name'];
	}

	/*
	 * gettmpname()
	 * get tmp name of file
	 * return tmp name
	 */
	public function gettmpname(){
		return $this->filename['tmp_name'];
	}
	/*
	 * gettype()
	 * get type of file
	 * return type
	 */
	public function gettype(){
		return $this->filename['type'];
	}

	/*
	 * getsize()
	 * get size of file
	 * return size;
	 */
	public function getsize(){
		return $this->filename['size'];
	}

	/*
	 * getextension
	 */
	public function getextension(){
		$ext = explode('.', $this->getname());
		return array_pop($ext);
	}

	/*
	 * move()
	 * file move
	 * return bool
	 */
	public function move($name = null, $path = null){

		$newname = ($name == null) ? $this->getname() : $name;
		$newpath = ($path == null) ? $this->setpath : $path;
		$this->setpath = $newpath;

		$do = move_uploaded_file($this->gettmpname(), $newpath.$newname);
		if(! $do){
			echo 'error uploading file';
		}
		return true;
	}

	/*
	 * removefile
	 * return bool
	 */
	public function removefile(){
		if(file_exists($this->setpath.$this->getname())){
			unlink($this->setpath.$this->getname());
			return true;
		}
		return false;
	}

	/*
	 * _request()
	 * check exist key for request
	 * return anti injection || error
	 */
	public function _request($name, $request){
		$input = null;
		if(array_key_exists($name, $request)){
			if($name == 'pass' || $name == 'password'){
				$input = base64_encode($request[$name]);
			}else{
				$input = (is_array($request[$name])) ? $request[$name] : htmlspecialchars($request[$name]);
			}
			return $this->verified_input($input);
		}else{
			//echo 'Request {'. $name .'} does not exist in request';
			return null;
		}
	}

	/*
	 * verified_input
	 * remove some text injection
	 * return string
	 */
	public function verified_input($input){
		return preg_replace(("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$input);
	}

	/*
	 * __get
	 * get magic name request
	 * return isfile()
	 */
	function __get($name){
		return $this->isfile($name);
	}
}