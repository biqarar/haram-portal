<?php 
/**
* 
*/
class model extends main_model
{
	public function post_list() {
		$table = config_lib::$aurl[1];
		$table = "table".ucfirst($table);
		$ret = $this->sql()->$table();

		// $field = post::field();
		// if($field && preg_match("/\,|\s|\-/",$field)){
		// 	$field = preg_split("/\,|\s|\-/",$field);
		// 	foreach ($field as $key => $value) {
		// 		$f = "field".ucfirst($value);
		// 		$ret->$f();
		// 	}
		// }
		$return = $ret->select()->allAssoc();
		// print_r($)
		debug_lib::msg("assoc", $return);
	}
}
?>