<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Instance Function
 * Created by Kang Hen
 * Dec 2016
 */

/*
 redirect()
 */
function redirect($url){
	header('location:'. url() . $url);
}

/*
 asset()
 */
function asset($url = null){
	$http = explode('/',ltrim($_SERVER['PHP_SELF'],'/'));

	if($url == null){
		return $location = url() .'public/';
	}else{
		return $location = url() .'public/'. $url;
	}
}

/*
 url()
 */
function url($url = null){
	$http = explode('/',ltrim($_SERVER['PHP_SELF'],'/'));

	if($url == null){
		return $location = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://'.$_SERVER['HTTP_HOST']. '/' . $http[0] .'/';
	}else{
		return $location = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://'.$_SERVER['HTTP_HOST']. '/' .$http[0] .'/'. $url;
	}
}

/*
 * error reporting()
 */
function report_error($e = array()){
	global $development;

	if($development == 'development' || $development == 'testing'){
		error($e);
	}else{
		error404();
	}
}
/*
 * error 404()
 */
 function error404(){
	include APP_PATH.'/view/error/error404.php';
}

/*
 * error()
 */
 function error($err = array()){
	include APP_PATH.'/view/error/error.php';
}

/*
 * get current url
 */
function getcurrenturl(){
	/* get server host*/
	$server = $_SERVER['HTTP_HOST'];

	/* get request uri */
	$uri = $_SERVER['REQUEST_URI'];

	/* parsing url and save to $this->url */
	$current = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $server . $uri ;
	return $current;
}