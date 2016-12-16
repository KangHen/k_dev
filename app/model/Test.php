<?php
defined('APP_PATH') OR exit('No direct script access allowed');

class Test extends Model{

	protected $table = 'test';
	protected $primarykey = 'id_test';

	public $times = false;

	public function lists(){
		return $this->select('*')->fetch();
	}
}