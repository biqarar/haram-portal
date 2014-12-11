<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/

class model extends main_model{

	public function sql_getField($table = false) {
		$sql = new dbconnection_lib;
		$q = $sql->query("select COLUMN_NAME from information_schema.columns 
							where TABLE_SCHEMA = 'quran_hadith' 
							AND TABLE_NAME = '$table'");
		return $q->allAssoc('COLUMN_NAME');
	}

	public function post_search() {
			// var_dump(post::name());
		exit();
	}
}
?>