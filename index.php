<?php
/* SYS_PATH system file*/
define('SYS_PATH', 'sys');

/* APP_PATH application path */
define('APP_PATH', 'app');

/* include Service file*/
require SYS_PATH.'/Service.php';

/* config */
require APP_PATH.'/config/config.php';

/* register file for to be load */
$service = array(
				'Loader'	 => SYS_PATH.'/Loader',
				'Route' 	 => SYS_PATH.'/Route',
				'Request'	 => SYS_PATH.'/Request',
				'Response'	 => SYS_PATH.'/Response',
				'Connection' => SYS_PATH.'/Connection',
				'Form'		 => SYS_PATH.'/Form',
				'Func'	 	 => SYS_PATH.'/Func',
				'Builder' 	 => SYS_PATH.'/Builder',
				'Model' 	 => SYS_PATH.'/Model',
				'View' 		 => SYS_PATH.'/View',
				'Controller' => SYS_PATH.'/Controller',
				'Web' 		 => SYS_PATH.'/Web'
			);
/*
 * use_session
 * if set true, then start session
 */

/* if session = true */
if($use_session == true){
	$service = array_merge($service, array(SYS_PATH => 'Session'));
}

/* register them */
Service::register($service);

/*
 * global development
 * get development version
 */

/* development && testing */
if($development == 'development' || $development == 'testing'){
	error_reporting(E_ALL);
/* production */
}else{
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE & ~E_WARNING);
}

/* run web */
Web::run();