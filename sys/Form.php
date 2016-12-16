<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Form
 * Created by Kang Hen
 * Dec 2016
 */

class Form{
	
	/* form model */
	public static $model = false;

	/* data model */
	public static $datamodel = null;
	
	/* form open */
	static function open($target = array('url'=>null, 'id'=>0, 'method'=>'POST'), $model = null, $option = array())
	{
		$opt = $html = $passid = '';

		if($model <> null){
			self::$model = true;
			self::$datamodel = $model;
		}

		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . "='" .$val."'";
			}
		}
		$method = isset($target['method']) ? 'GET' : 'POST';
		$passid = (isset($target['id']) && $target['id'] > 0) ? '/'.$target['id'] : ''; 
		$html .= "<form name='form' method='".$method."' action ='".$target['url'].$passid."' ". $opt .">";
		echo $html;
	}

	/* form close */
	static function close(){
		echo '</form>';
	}

	/* select form */
	static function select($name, $data = array(), $selected = null, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . "='" .$val."' ";
			}
		}

		if(self::$model == true && isset(self::$datamodel->$name)){
			$selected = self::$datamodel->$name;
		}

		$html = "<select name='". $name ."' ". $opt .">";
		foreach ($data as $key => $value) {
			if(is_array($selected)){
				foreach ($selected as $s) {
					if($key == $s){
						$html .= "<option value='". $key ."' selected>". $value ."</option>";
					}else{
						$html .= "<option value='". $key ."'>". $value ."</option>";
					}
				}
			}else{
				if($key == $selected){
					$html .= "<option value='". $key ."' selected>". $value ."</option>";
				}else{
					$html .= "<option value='". $key ."'>". $value ."</option>";
				}
			}			
		}
		$html .= "</select>";

		echo $html;
	}

	/* form text */
	static function text($name, $value = null, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . "='".$val. "' ";
			}
		}

		$value = (self::$model == true && isset(self::$datamodel->$name)) ? self::$datamodel->$name : null;

		$html .= "<input type='text' name='". $name ."' value='". $value ."' ". $opt ."/>";

		echo $html;
	}

	/* form number */
	static function number($name, $value = null, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . "='".$val. "' ";
			}
		}

		$value = (self::$model == true && isset(self::$datamodel->$name)) ? self::$datamodel->$name : null;

		$html .= "<input type='number' name='". $name ."' value='". $value ."' ". $opt ."/>";

		echo $html;
	}

	/* form  */
	static function cfile($name, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . "='".$val. "' ";
			}
		}


		$html .= "<input type='file' name='". $name ."' ". $opt ."/>";

		echo $html;
	}

	/* form radio */
	static function radio($name, $data = array(), $selected, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . '=' .$val;
			}
		}
		if(self::$model == true && isset(self::$datamodel->$name)){
			$selected = self::$datamodel->$name;
		}

		foreach ($data as $key => $value) {
			if($key == $selected){
				$html .="<input type='radio' name='". $name ."' value = '". $key ."' ". $opt ." checked/> ". $value;
			}else{
				$html .="<input type='radio' name='". $name ."' value = '". $key ."' ". $opt ."/> ". $value;
			}
		}
		echo $html;
	}

	/* form checkbox */
	static function checkbox($name, $data = array(), $selected, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . '=' .$val;
			}
		}
		if(self::$model == true && isset(self::$datamodel->$name)){
			$selected = self::$datamodel->$name;
		}

		foreach ($data as $key => $value) {
			if($key == $selected){
				$html .="<input type='checkbox' name='". $name ."' value = '". $key ."' ". $opt ." checked/> ". $value;
			}else{
				$html .="<input type='checkbox' name='". $name ."' value = '". $key ."' ". $opt ."/> ". $value;
			}
		}
		echo $html;
	}

	/* textarea */
	static function texarea($name, $value = null, $option = array()){
		$opt = '';
		$html = '';
		if(count($option) > 0){
			foreach ($option as $key => $val) {
				$opt .= $key . '=' .$val;
			}
		}

		$value = (self::$model = true && isset(self::$datamodel->$name)) ? self::$datamodel->$name : null;

		$html .= "<texarea name='". $name ."' ". $opt .">". $value . "</textarea>";

		echo $html;
	}

	/* form hidden */
	static function hidden($name, $value = null){
		$html = '';
		if(self::$model == true && isset(self::$datamodel->$name)){
			$value = self::$datamodel->$name;
		}
		
		$html .= "<input type='hidden' name='". $name ."' value='". $value ."' />";

		echo $html;
	}

}