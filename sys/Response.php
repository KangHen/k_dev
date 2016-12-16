<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Response
 * Created By Kang Hen
 * Dec 2016
 */

class Response{

	/* url */
	public $url = array();

	/* params */
	public $params = array();

	/* collected all variabel */
	public $collect = array();

	/* scriptname */
	public $scriptname = 'index.php';

	/* response */
	public $response = array();

	/* default controller */
	public $defaultcontroller = 'IndexController';

	/* default method */
	public $defaultmethod = 'index';

	/* identity */
	public $identity = 'Controller';

	/* status */
	public $statuserror = false;

	/* error */
	public $errorException = array();

	/* isdir */
	public $dir = '';

	/*
	 * create()
	 * create response
	 * collect parse url to array(s => $scriptname, c => controller, m => method );
	 * collect params array from url , && if params is callable so send response to new callable
	 */
	public function receive(){
		/* get server host*/
		$server = $_SERVER['HTTP_HOST'];

		/* get request uri */
		$uri = $_SERVER['REQUEST_URI'];

		/*
		 * get main index
		 * http://localhost:8000/folder/index.php/etc/etc
		 * get the main index.php
		 * so then save to $this->scriptname
		 */
		$scriptname = explode('/', ltrim($_SERVER['SCRIPT_NAME'], '/'));
		$this->scriptname = array_pop($scriptname);

		/* parsing url and save to $this->url */
		$full_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $server . $uri ;
		$this->url = parse_url($full_url);

		/* get controller && method */
		/* parse path & convert to array */
		$path = explode('/',ltrim(rtrim($this->url['path'], '/'), '/'));

		/* check if script name on url */
		$existmain = array_search($this->scriptname, $path);
		$newpath = array();

		if($existmain <> false){
			/* if in array && scriptname position > 0, shift first */
			$newpath = array_slice($path, $existmain + 1);
		}else{
			array_shift($path);
			$newpath = $path;
		}

		/* collect */
		$merge_path = array_merge(array($this->scriptname), $newpath);

		/* set default controller && method */
		$setdefault = array('c'=>$this->defaultcontroller, 'm'=>$this->defaultmethod);

		$this->collect['sc'] = $merge_path[0];

		/* get config routes */
		include APP_PATH. '/config/routes.php';
	
		/*$rj = fopen(APP_PATH.'/cache/route.json', 'w');
		$write = json_encode($merge_path);
		fwrite($rj, $write);
		fclose($rj);*/
		
		$st_fol = 1;
		if(count($merge_path) == 1){
			$this->collect = array_merge($merge_path, $setdefault);
		}elseif(count($merge_path) == 2){
			$this->collect = array_merge($merge_path, array('c'=>$this->parsecontroller($merge_path[1]), 'm'=>$this->defaultmethod));
		}else{
			foreach ($routes->folder as $folders) {
				if($folders == $merge_path[1]){
					$st_fol = 2;
					$this->dir = $folders.'/';
				}
			}
			$methods_set = isset($merge_path[$st_fol+1]) ? $merge_path[$st_fol+1] : $this->defaultmethod;
			$set_attr = array('c'=>$this->parsecontroller($merge_path[$st_fol]), 'm'=>$methods_set);
			$this->collect = array_merge($merge_path, $set_attr);
			$this->params = array_slice($merge_path, $st_fol+2);
			//var_dump($this->params);
		}
		
		/* arrange to map collect response */
		/*$st = 0;
		if(count($merge_path) > 2)
		{
			for($i = 0; $i < count($merge_path); $i++){
				if($i == $st){
					$this->collect['sc'] = $merge_path[$st];
					$st = $st+1;
				}elseif($i == $st){

					$this->collect['c'] = isset($merge_path[$st]) ? $this->parsecontroller($merge_path[$st]) : $this->defaultcontroller;
					$st= $st+1;
				}elseif($i == $st){
					$this->collect['m'] = isset($merge_path[$st]) ? $merge_path[$st] : $this->defaultmethod;
					$st = $st+1;
				}else{
					$this->params[] = $merge_path[$i];
				}
			}
		}elseif(count($merge_path) > 1){
			$this->collect = array('sc'=>$merge_path[0], 'c'=>$this->parsecontroller($merge_path[1]), 'm'=>$this->defaultmethod);
		}else{
			$this->collect = array_merge($merge_path, $setdefault);
		}


		/* $require file */
		$require_file = null;

		/*
		 * check exist controller with routes map
		 */
		
		/* cek key exist set lower */
		//$key_exist = str_replace('controller','',strtolower($this->collect['c']));

		//if(array_key_exists($key_exist, $routes->map())){

			/* collect map routes */
			//$map = $routes->map();

			/* get location folder*/
			//$ctrl_location = $map[$key_exist];

			/* get file controller name */
			//$ctrl_name = $this->collect['c']. '.php';
			/* set require file */
			//$require_file = $ctrl_location. '.php';

			//$set_new_controller = explode('/', $ctrl_location);
			
		//}else{
			/* get file controller name */

			$ctrl_name = $this->dir.$this->collect['c']. '.php';

			/* set require file */
			$require_file = $ctrl_name;
		//}
		/* check file exists */
		if(file_exists(APP_PATH . '/controller/' .$require_file)){
			include_once APP_PATH . '/controller/' .$require_file;
		}else{
			$exception = 'Controller file {' .$this->collect['c']. '} does not exists';
			$this->statuserror = true;
			$this->errorException = array('e' => $exception);
			return false;
		}

		/* Reflection class, to check is callable  */
		/*if((is_dir(APP_PATH.'/controller/'.$key_exist))){ } */

		$classes = $this->collect['c'];
		$reflection = new Reflectionclass($classes);

		/*
		 * check method exist
		 * if exist get class method
		 * check method is hinting or normal params
		 * if hinting response will pas with new $callable but if not skip this
		 */
		if(method_exists($classes, $this->collect['m']) == true){
			$method = $reflection->getMethod($this->collect['m'])->getParameters();

			if(count($method) > 0){
				if($method[0]->getClass() <> NULL){
					$callable = $method[0]->getClass()->getName();
					$this->params = (!empty($callable)) ? array_merge(array(new $callable), $this->params) : $this->params;
				}			
			}
		}

		return $this->collect;
	}


	/*
	 * parsecontroller
	 */
	public function parsecontroller($ctrl){
		return ucfirst($ctrl).$this->identity;
	}

	/*
	 * send()
	 * send requset url to action view
	 * call_user_func_array($controller, $params)
	 */
	public function send(){
		/* receive */
		$r = $this->receive();
		
		/* global development */
		global $development;

		/* check error */
		if($this->statuserror == true && count($this->errorException) > 0){
			if($development == 'development' || $development == 'testing'){
				$this->error($this->errorException);
			}else{
				$this->error404();
			}
		}elseif(method_exists($r['c'], $r['m']) == false){
			if($development == 'development' || $development == 'testing'){
				$e = 'Method '. $r['m'] .' does not exist in class '. $r['c'];
				$this->error(array('e' => $e));
			}else{
				$this->error404();
			}
		}else{
			/* call user func array */
			echo call_user_func_array(array(new $r['c'], $r['m']) , $this->params);
		}
		
	}

	/*
	 * error 404
	 */
	public function error404(){
		include APP_PATH.'/view/error/error404.php';
	}

	/*
	 * error
	 */
	public function error($err = array()){
		include APP_PATH.'/view/error/error.php';
	}
}