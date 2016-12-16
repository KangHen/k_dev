<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class View
 * Created By Kang Hen
 * Dec 2016
 */

class View{
	
	/* env */
	public $_env = array();

	/* save data */
	public $data = array();

	/* parse ext */
	public $ext = '.se';

	/*  */
	public $view = null;
	function __construct(){
		$this->view = &$this;
	}

	/*
	 * make()
	 * render the file view
	 */
	function make($view, $data = array()){
		$this->_env = array('_files'=>$view, '_var'=>$data);
		return $this->__view($this->_env);
	}

	/*
	 * content()
	 * if have template
	 */
	function content(){
		
	}

	/*
	 * __view
	 * string
	 */
	function __view($data = array()){
		$this->data = array_merge($this->data, $data['_var']);
		unset($data['_var']);
		extract($this->data);

		$viewfile = null;

		$viewparse = APP_PATH . '/view/' . $data['_files'];

		if(file_exists($viewparse.'.se.php')){
			$viewfile = $this->_parse($data['_files']);
		}else{
			if(file_exists($viewparse.'.php')){
				$viewfile = $viewparse . '.php';
			}else{
				report_error();
			}
		}


		ob_start();
		include_once $viewfile;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	/*
	 * parse
	 * parse view
	 */
	function _parse($view){

		/* encrypt filename */
		$file = md5($view.$this->ext).'.php';

		/* 
		 * check if file exist in tmp path && if last modified in view file 
		 * if in view path last modified > tmp path , && render again
		 * if in tmp path > view return file name
		 * return file encrypt name 
		 * */
		if(! file_exists(APP_PATH.'/tmp/'.$file) || $this->lastmodified($view) == false){
			
			$buffer = file_get_contents(APP_PATH. '/view/' .$view.$this->ext.'.php');
		
			$replace = preg_replace('/\{\{(.+?)\}\}/s',trim('<?=\1?>'),$buffer);
			$replace = preg_replace('/[@][a-z]{4}[(](.+?)[)]/s',trim('<?php foreach(\1) { ?>'),$replace);
			$replace = str_replace('@endloop', '<?php } ?>', $replace);
			
			file_put_contents(APP_PATH.'/tmp/'.$file, $replace);
		}

		return APP_PATH.'/tmp/'.$file;

	}

	/*
	 * lastmodified
	 * bool
	 */
	function lastmodified($view){
		/* encrypt filename */
		$e = APP_PATH.'/tmp/'.md5($view.$this->ext).'.php';
		$f = APP_PATH.'/view/'.$view.$this->ext.'.php';

		/* created variabel int */
		$a = $b = 0;
		
		/* check if file exist in view path */
		if (file_exists($f)) {
		    $a = filemtime($f);
		}
		
		/* check if exist in tmp path */
		if (file_exists($e)) {
		    $b = filemtime($e);
		}
		
		/* calculate for last modified and return bool */
		if($b > $a){
		    return true;
		}else{
		    return false;
		}
	}
}