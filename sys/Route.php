<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class route
 * for special action
 * Created By Kang Hen
 * Dec 2016
 */

class Route{

	/* collection route */
	public $collection = array();

	/* folder collection */
	public $folder = array();

	/*
	 * add()
	 * special add custome route
	 * if controller include a folder you must add route folder
	 * return $collection
	 */
	public function add($request, $controller){
		/* collect to request => controller */
		$collection = array(ltrim($request, '/') => $controller);

		/* save and merge collection to $this->collection */
		$this->collection = array_merge($this->collection, $collection);

		return $this->collection;
	}

	/*
	 * map()
	 * get all collection
	 * map the collection and then next to be pass to response
	 * return $collection
	 */
	public function map(){
		return $this->collection;
	}

	/*
	 * directory route
	 */
	public function directory($dirname){
		$this->folder = array_merge($this->folder, array($dirname));
		return $this->folder;
	}

	/*
	 * cache
	 */
	public function cache(){
		
	}
}