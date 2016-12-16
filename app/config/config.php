<?php
/* file config */

/* set default time zone*/

date_default_timezone_set('ASIA/JAKARTA');
/*
 * db variabel
 * array()
 * connection file for database
 */
$db = array(
		'host'     => 'localhost',
		'user'     => 'root',
		'password' => '',
		'database' => 'sar_dev'
	);

/*
 * development variabel
 * development if proces is development
 * production if production (ready use)
 * test if testing 
 */
$development = 'development';


/*
 * session
 * default is false
 * when you change value to true, then session can be set , get or destroy
 * encript session (false)
 * set the encrypt data , if you set true, the data session was be encrypt
 * you can get the data with $session->get(str)
 */
$use_session = false;
$encrypt_session = false;
$session_name = 'sar_session';
/*
 * session engine
 * session || cookie
 */
$session_engine = 'session';

/*
 * encrypt input
 * if input want to encrypt
 */
$encrypt_data = false;

/*
 * middleware
 * set middlewere here
 * if you set middleware , web automatically filter access with middleware
 * example $middleware = array('superadmin','admin','user','guest')
 * you must set the user type for like that
 * 
 */
$middleware = array('superadmin', 'admin', 'user', 'sikd');

/*
 * chache
 * set chache content
 * set chache content table
 */
$chache_content = false;
$chache_table_content = false;
