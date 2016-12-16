<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Service
 * Created By Kang Hen
 * Dec 2016
 */
class Service{

	/*
	 * services
	 * save all services pass
	 */
	public static $services = array();

	/*
	 function register , set register file include
	 */
	
	public static function register($register = array()){
		/* set the all services to array */
		$services = array();

		/* call all services and check the file exists */
		foreach ($register as $key => $value) {
			$services[] = $key;
			if(file_exists($value.'.php')){
				include $value.'.php';
			}else{
				echo 'File {'. $value .'} does not exists';
			}
		}

		/* set to static $services */
		self::$services = $services;

		//return new self;
	}

	/*
	 * inject()
	 * inject services class
	 * return $inject
	 */
	public static function inject($services){
		/* $classname set ucfirst */
		$classname = ucfirst($services);

		//in_array(needle, haystack)
		/* check the exists class */
		if(class_exists($classname)){
			return new $classname;
		}else{
			echo 'Service {'. $services .'} not register';
		}
	}

	/*
	 * allservice()
	 * get all service register
	 * return $services
	 */
	public static function allservice(){
		return self::$services;
	}
}

