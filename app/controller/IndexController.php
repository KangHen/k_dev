<?php
defined('APP_PATH') OR exit('No direct script access allowed');

class IndexController extends Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('test');
		$this->template = 'layouts/layout.app';
	}

	function index(){
		$this->set(array('content'=>'test/index','tes'=>'hello world'));
		return $this->render();
	}

	function show(){
		$this->test->list();
		var_dump($this->test->dumpSql());
	}
}