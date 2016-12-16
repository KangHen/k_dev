<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Controller
 * Created by Kang Hen
 * Dec 2016
 */

class Controller{

	/* view */
	public $params = array();

	/* load */
	public $load;

	/* view */
	public $view;

	/* session */
	public $session = array();

	/* accept key */
	public $accept = array();

	/* template set */
	public $template = null;

	/* getshared */
	public $getShared = array();

	function __construct(){
		$this->load = new Loader;
		$this->view = new View;

		//$this->middleware()->only();
	}

	/*
	 * set()
	 * set parameter
	 */
	function set($data = array()){
		$this->params = array_merge($this->params, $data);
		return $this->params;
	}

	/*
	 * render
	 */
	function render($render = null){
		$r = ($render == null) ? $this->template : $render;
		if($this->getShared <> null){
			$this->params = array_merge($this->getShared, $this->params);
		}
		return $this->view->make($r, $this->params);
	}

	/* 
	 * middleware 
	 */
	function middleware(){
		$session = new Session;
		$this->session = $session->getAlldata();
		return $this;
	}

	/*
	 * all()
	 * middleware all users
	 * $this->middleware()->all()
	 */
	function all(){
		//return $all;
		foreach ($this->session as $data) {
			if(!empty($data)){
				return true;
			}else{
				break;
				return false;
				//return redirect('/');
			}
		}
	}
	
	/*
	 * only()
	 * middleware only user
	 * $this->middleware()->only()
	 */
	function only(){
		$middleware = func_get_args();

		$found = array();


		foreach ($this->session as $key => $value) {
			if(in_array($key, $middleware) && !empty($this->session[$key])){
				$found[] = true;
			}
		}

		if(count($middleware) == count($found)){
			$this->accept = $found;
			return true;
		}else{
			return false;
			//return redirect('/');
		}
	}

	/*  accept */
	function _accept(){
		return $this->accept;
	}

	function test(){
		echo 'llll';
	}

	/* __get */
	function __get($name){
		$class = ucfirst($name);
		if(class_exists($class)){
			return $this->$name = new $class;
		}
	}
	
}