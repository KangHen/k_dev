<?php

define('APP_PATH','app');
include_once 'sys/Service.php';
//include_once 'app/config/config.php';
$service = array('Loader'=>'sys/Loader', 'View'=>'sys/View','Controller'=>'sys/Controller','Session'=>'sys/Session');

Service::register($service);

class test extends Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('produk');
	}

	function testing(){
		
	}

	function test_middleware(){
		
	}

}


$test = new test;
$test->test_middleware();
