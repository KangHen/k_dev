<?php
/*
 * Class Reader
 * Created By Kang Hen
 * Dec 2016
 */

/* call PHPExcel Library File */
include_once APP_PATH.'/helper/PHPExcel.php';
include_once APP_PATH.'/helper/PHPExcel/IOFactory.php';

class Reader{

	/*
	 * variabel
	 */
	
	public $readfiles = null;

	/*
	 * dataExcel
	 * load data from file excel, then convert data to json (object)
	 * object
	 */
	function read($filedata = null){

		//define variabel
		$filename = ($filedata == null) ? $this->readfiles : $filedata;
		$data = array();
		$column = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AW','AX','AY','AZ');

		//load and call PHP Excel Library
		$excel = PHPExcel_IOFactory::createReaderForFile($filename);
		$read = $excel->load($filename);
		$sheet = $read->getSheet(0);
		$highRows = $sheet->getHighestRow();

		//find high column in array
		$findHighColumn = array_search($sheet->getHighestColumn(), $column);

		//Loop
		for($i = 2; $i <= $highRows; $i++){
			for($c = 0; $c <= $findHighColumn; $c++){
				$name = strtolower(str_replace(' ', '', $sheet->getCell($column[$c].'1')->getValue()));
				$data[$i-2][$name] = $sheet->getCell($column[$c].$i)->getValue();
			}
		}

		//return
		return json_decode(json_encode($data), FALSE);
	}

	/*
	 * upload
	 * if file be upload before, uploaded file and must call be read
	 * ($this)
	 */
	
	function upload($filename, $pathname){

		/* created filedata if upload file */
		$this->readfiles = $pathname.$filename;

		//move_uploaded_file(, $pathname);
	}
	
}