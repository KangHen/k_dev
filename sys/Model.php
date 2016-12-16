<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Model
 * Created By Kang Hen
 * Dec 2016
 */

class Model extends Builder{

	/* definied all variabel */

	/* $data for all data*/
	protected $data = array();

	/* $table for table */
	protected $table = null;

	/* $protected $primaryKey */
	protected $primarykey = 'id';

	/* $pk_type */
	protected $pk_type = 'int';

	/* times */
	public $times = true;

	/* except */
	protected $except = array();
	
	/* pass id */
	protected $pass = 0;


	/* get find primary key pass */
	public function find($id = 0){
		$builder = null;

		if(is_array($id)){
			$builder = $this->findIn($id);
		}else{
			$findone = $this->findIn(array($id));
			foreach ($findone as $data) {
				$builder = $data;
			}
		}
		return $builder;
	}

	/*
	 * findwhere($pass, $data)
	 * find where with pass parameter
	 * return result
	 */
	function findwhere($pass, $data){
		$findwhere = null;

		if(is_array($data)){
			$findwhere = $this->select('*')->whereIn($pass, $data);
		}else{
			$findwhere = $this->select('*')->where($pass, $data);
		}
		return $findwhere->fetch();
	}

	/*
	 * findnotin
	 * find pass except data
	 * return result
	 */
	function findnotin($pass, $data){
		$findnotin = null;
		$id = null;

		if(is_array($data)){
			$id = $data;
		}else{
			$id = array($data);
		}
		$findnotin = $this->select('*')->whereNotIn($pass, $id);
		return $findnotin->fetch();
	}
	/*
	 * toObject
	 * return object
	 */
	function toObject($object){
		$data = array();
		foreach ($object as $value) {
			$data = $value;
		}
		return $data;
	}

	function toArray($obj){
		$data = array();

		foreach ($obj as $e) {
			$data[] = (array) $e;
		}

		return $data;
	}

	/*
	 * save()
	 * this function for two action insert && update
	 * if class is call new then function return insert
	 * if class is pass , the pass set id then function return to update
	 * return save
	 */
	function save(){
		if($this->pass == 0){
			if($this->times == true){
				$times = array('created_at'=>date('Y-m-d'));
				$this->data = array_merge($this->data, $times);
			}
			$save = $this->insert($this->table, $this->data);
		}else{
			if($this->times == true){
				$times = array('updated_at'=>date('Y-m-d'));
				$this->data = array_merge($this->data, $times);
			}
			$this->pk_typedata();
			$save = $this->update($this->table, $this->data, $this->pass);
		}
		unset($this->data);
		return $save;
	}

	function getData(){
		return $this->data;
	}

	/*
	 * delete()
	 * delete row
	 * return delete
	 */
	function delete($field = null, $id = null){
		$delete = null;

		$fie = ($field == null) ? null : $field;
		$pass = ($id == null) ? $this->pass : $id;

		if($this->pass == 0){
			$delete = $this->destroy_all($this->table);
		}else{
			$delete = $this->destroy($this->table, $fie, $pass);
		}
		
		return $delete;
	}

	/*
	 * pass()
	 * function pass set the protected pass, the protected pass for set pass argument
	 */
	function pass($id = null){
		$this->pass = $id;
		return $this;
	}

	/*
	 * pk_typedata
	 */
	function pk_typedata(){
		if($this->pk_type == 'int'){
			$this->pass = abs((int) $this->pass);
		}else{
			return $this->pass;
		}
	}

	/*
	 * __set()
	 * magic method for set field and value
	 * retur $data
	 */
	function __set($name, $value){
		$set = array($name => $value);
		$this->data = array_merge($this->data, $set);
		return $this->data;
	}

}