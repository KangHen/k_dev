<?php
defined('APP_PATH') OR exit('No direct script access allowed');
/*
 * Class Builder
 * Created by Kang Hen
 * Dec 2016
 */

class Builder{

	/* open connection */
	protected $conID = null;

	/* close connection*/
	protected $closeID = null;

	/* $select for select sql */
	public $select;

	/* order statement */
	public $order = array();

	/* limit statemnet */
	public $limit = 'LIMIT';

	/* $where for where statement sql  */
	public $where = array();

	/* whereIn for IN statement */
	public $wherein = 'IN';

	/* wherenotin for statement NOT IN */
	public $wherenotin = 'NOT IN';

	/* leftjoin */
	public $leftjoin = array();

	/* rightjoin */
	public $rightjoin = array();

	/* fulljoin */
	public $fulljoin = array();

	/* join */
	public $join = array();

	/* arguments */
	public $arguments = null;

	/* active class  */
	public $activeclass = null;

	/* fetch object */
	public $fetchdata = array();

	/* set table default by null*/
	protected $table = null;

	/* set primarykey default by id */
	protected $primarykey = 'id';

	/* times for created_at & updated_at*/
	public $times = true;

	/* sql */
	public $sql = '';

	/* query parse */
	public $query_parse = false;

	/* except */
	protected $except = array();
	
	/* $result */
	public $result_data;

	/* $dump */
	public $dump = null;

	/* constructor builder */
	function __construct(){
		
	}

	function call_class(){
		return new $this;
	}

	/* openconnection function */
	function openconnection(){
		return new Connection;
	}

	/* close connection function */
	function closeconnection(){
		$connection = new Connection;
		return $connection->close();
	}

	/* get table name of childreen class */
	function tablename(){
		return $this->table;
	}

	/* set primaryKey of childreen class */
	function primarykey(){
		return $this->primarykey;
	}

	/* 
	 * query class for execute sql statement 
	 * if sql statement is set then pass to variabel $sql
	 * return $this->sql
	 */
	function query($sql){
		$this->openconnection();
		$this->result_data = mysql_query($sql) or die(report_error(array(mysql_error())));
		$this->closeconnection();

		//$this->query_parse = true;
		return $this;
	}

	/* arrange() 
	 * arrange the sql statetment to a right
     * return $this->sql
	*/
	function arrange(){

		/* set all variable */
		$join = $where = $wherein = $wherenotin = $order = $limit = $andin = $andnotin = '';

		/* set join LEFTJOIN, RIGHTJOIN, FULLJOIN && JOIN */
		if(count($this->join) > 0){
			$join .= implode(' ', $this->join);
		}elseif(count($this->leftjoin) > 0){
			$join .= implode(' ', $this->leftjoin);
		}elseif(count($this->rightjoin) > 0){
			$join .= implode(' ', $this->rightjoin);
		}elseif(count($this->fulljoin) > 0){
			$join .= implode(' ', $this->fulljoin);
		}else{
			$join = '';
		}

		/* set $where from $this->where , && if $this->where > 1 implode with AND */
		$where = (count($this->where) > 0) ? ' WHERE '. implode('AND ', $this->where) : '';

		/* set $wherein from $this->wherein */
		$wherein = ($this->wherein <> 'IN') ? ' WHERE ' .$this->wherein : '';

		/* set $wherenotin from $this->wherenotin */
		$wherenotin = ($this->wherenotin <> 'NOT IN') ? ' WHERE ' .$this->wherenotin : '';

		/* set order */
		$order = (count($this->order) > 0) ? implode(', ', $this->order): ' ORDER BY '.$this->primarykey().' DESC';

		/* limit */
		$limit = ($this->limit <> 'LIMIT') ? $this->limit : '';

		/* arrange $this->sql from all variable pass*/
		$this->sql = $this->select . ' FROM ' . $this->tablename();

		/* if before IN have WHERE then add AND */
		if($wherein <> 'IN' && count($this->where) > 0 && $wherein <> ''){
			$andin = ' AND ';
		}

		/* if before NOT IN have WHERE then add AND */
		if($wherenotin <> 'NOT IN' && $wherenotin <> ''){
			$andnotin = ' AND ';
		}

		/* merge all statement sql */
		$this->sql .= $join . $where . $andnotin . $wherein . $andin . $wherenotin . $order . $limit;

		//reset all
		$this->leftjoin = $this->rightjoin = $this->fulljoin = $this->join = $this->order = $this->where = array();
		$this->limit = 'LIMIT';
		$this->wherein = 'IN';
		$this->$wherenotin = 'NOT IN';

		//show the dump sql
		$this->dump = $this->sql;

		//return sql
		return $this->sql;
	}

	/*
	 * fetch ()
	 * return array data stdObject
	 */
	function fetch($object = null){
		
		/* query */
		if($object == null){
			$this->query($this->arrange());
			$obj = $this->result_data;
			$this->resetParams();
		}else{
			$obj = $object;
		}

		/* check the obj, if obj from $this->sql so method is chaining but if obj from pass then execute */
		
		$fetch = array();
		
		while($data = mysql_fetch_object($obj)){
			$fetch[] = $data;
		}
		
		return $fetch;
	}

	/*
	 * dump
	 * return string
	 */
	function dumpSql(){
		return $this->dump;
		$this->dump = null;
	}
	/*
	 * reset params
	 */
	function resetParams(){
		return $this->sql = null;
	}

	/* select() 
	 * select with get argument
	 * return $this
	*/
	function select(){
		/* get arguments select */
		$get_arguments = func_get_args();

		
		/* check if arguments > 1*/
		if(count($get_arguments) > 1){
			$this->select = sprintf("SELECT %s ", implode(', ', $get_arguments));
		}else{
			$this->select = sprintf("SELECT %s ", $get_arguments[0]);
		}

		//return $this->select;
		return $this;
	}

	/* 
	 * order()
	 * function sorting field with order
	 * merge array with for seting order if order > 1
	 * return $this
	 */
	function order($field, $order = 'ASC'){
		$this->order = array_merge($this->order, array(' ORDER BY '. $field . ' ' .$order));
		return $this;
	}

	/*
	 * where()
	 * where statement sql
	 * merge argument if where pass > 1
	 * return $this
	 */
	function where($field, $need){
		$this->where = array_merge($this->where,array($field."='".$need."'"));
		return $this;
	}

	/*
	 * whereIn()
	 * statement IN SQL
	 * return $this
	 */
	function whereIn($field, $need = array()){
		$this->wherein = $field .' IN (' .implode(',', $need) .')';
		return $this;
	}

	/*
	 * whereNotIn()
	 * statetment NOT IN SQL
	 * return $this;
	 */
	function whereNotIn($field, $need = array()){
		$this->wherenotin = $field .' IN (' .implode(',', $need) .')';
		return $this;
	}

	/*
	 * limit()
	 * statement LIMIT SQL
	 * return $this
	 */
	function limit($start = 0, $end = 0){
		$from = $start;
		$to = ($end == 0) ? '' : ','.$end;
		$this->limit = ' LIMIT '. $from. $to;
		return $this;
	}

	/*
	 * leftJoin()
	 * statemnet LEFTJOIN SQL
	 * return $this
	 */
	function leftJoin(){
		$args = func_get_args();
		$this->arguments = ' LEFT JOIN '. $args[0] . ' ON ' . $args [1] . $args[2] . $args[3];
		$this->rightjoin = array_merge($this->rightjoin, array($this->arguments));
		return $this;
	}

	/*
	 * rightJoin()
	 * statemnet RIGHTJOIN SQL
	 * return $this
	 */
	function rightJoin(){
		$args = func_get_args();
		$this->arguments = ' RIGHT JOIN '. $args[0] . ' ON ' . $args [1] . $args[2] . $args[3];
		$this->rightjoin = array_merge($this->rightjoin, array($this->arguments));
		return $this;
	}

	/*
	 * fullJoin()
	 * statemnet LEFTJOIN SQL
	 * return $this
	 */
	function fullJoin(){
		$args = func_get_args();
		$this->arguments = ' FULL JOIN '. $args[0] . ' ON ' . $args [1] . $args[2] . $args[3];
		$this->rightjoin = array_merge($this->rightjoin, array($this->arguments));
		return $this;
	}

	/*
	 * join()
	 * statemnet JOIN SQL
	 * return $this
	 */
	function join(){
		$args = func_get_args();
		$this->arguments = ' JOIN '. $args[0] . ' ON ' . $args [1] . $args[2] . $args[3];
		$this->rightjoin = array_merge($this->rightjoin, array($this->arguments));
		return $this;
	}

	/*
	 * findIn()
	 * function find primarykey pass
	 * return array object
	 */
	function findIn($id = array()){
		$query = sprintf("SELECT * FROM %s WHERE %s IN (%s)", $this->tablename(), $this->primarykey(), implode(',', $id));
		$find = $this->execute($query);
		return $this->fetch($find);
	}

	/*
	 * max()
	 * statemnet MAX SQL
	 * return object
	 */
	function max($field = null){
		$f = ($field == null) ? $this->primarykey() : $field;

		$query = sprintf("SELECT MAX(%s) AS %s FROM %s", $f, $f, $this->tablename());
		$max = $this->execute($query);

		$data = $this->fetch($max);

		$builder = null;
		foreach ($data as $d) {
			$builder = $d;
		}
		return $builder->$f;
	}

	/*
	 * sum()
	 * statemnet SUM SQL
	 * return object
	 */
	function sum($field = null){
		$f = ($field == null) ? $this->primarykey() : $field;

		$query = sprintf("SELECT SUM(%s) AS %s FROM %s", $f, $f, $this->tablename());
		$sum = $this->execute($query);

		$data = $this->fetch($sum);

		$builder = null;
		foreach ($data as $d) {
			$builder = $d;
		}
		return $builder->$f;
	}

	/*
	 * count
	 */
	function count($field = null){
		$f = ($field == null) ? $this->primarykey() : $field;

		$query = sprintf("SELECT COUNT(%s) AS %s FROM %s", $f, $f, $this->tablename());
		$count = $this->execute($query);

		$data = $this->fetch($count);

		$builder = null;
		foreach ($data as $d) {
			$builder = $d;
		}
		return $builder->$f;
	}

	/*
	 * insert()
	 * function insert to the table
	 * $this->table set from get call class and get the table protected
	 * $field is field table
	 * $value is value pass, and value filter by htmlentities & specialchar
	 * return execute()
	 */
	function insert($table = null, $data = array()){
		$t = ($table == null) ? $this->table : $table;

		$field = $values = array();

		foreach ($data as $key => $value) {
			$field[] = $key;
			$values[] = sprintf("'%s'", $value);
		}

		$query = sprintf("INSERT INTO %s (%s) VALUES (%s) ", $t, implode(', ',$field), implode(', ',$values));
		
		return $this->execute($query);
	}

	/*
	 * update()
	 * function update to the table
	 * $this->table set from get call class and get the table protected
	 * $this->primarykey from get call class and get the primarykey protected
	 * $field is field table
	 * $value is value pass, and value filter by htmlentities & specialchar
	 * return execute()
	 */
	function update($table = null, $data = array(), $id = 0){
		$t = ($table == null) ? $this->tablename() : $table;

		$values = array();

		foreach ($data as $key => $value) {
			$values[] = sprintf("%s = '%s'", $key, $value);
		}

		$query = sprintf("UPDATE %s SET %s WHERE %s = '%s'", $t, implode(', ',$values), $this->primarykey(), $id);

		return $this->execute($query);
	}

	/*
	 * delete()
	 * delete row table
	 * can delete one by one or more than one
	 * return execute()
	 */
	function destroy($table = null, $field = null, $id = null){

		$t = ($table == null) ? $this->table() : $table;
		$f = ($field == null) ? $this->primarykey() : $field;
		if(is_array($id)){
			foreach ($id as $k) {
				$query = sprintf("DELETE FROM %s WHERE %s = '%s'", $t, $f, $k);
				$this->execute($query);
			}
			return true;
		}else{
			$query = sprintf("DELETE FROM %s WHERE %s = '%s'", $t, $f, $id);
			return $this->execute($query);
		}

	}

	/*
	 * empty()
	 * empty table
	 * return delete
	 */
	function destroy_all($table = null){
		$t = ($table == null) ? $this->table() : $table;
		$query = sprintf("DELETE FROM %s", $t);
		return $this->execute($query);
	}

	/*
	 * execute()
	 * execute sql statement
	 * like function query(), but return $execute not return $this
	 */
	function execute($sql){
		$this->openconnection();
		$execute = mysql_query($sql) or die(report_error(array(mysql_error())));
		$this->closeconnection();

		return $execute;
	}

}