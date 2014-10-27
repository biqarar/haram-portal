<?php 
/**
* 
*/
class model extends main_model
{
	public function post_text() {
		$table = config_lib::$aurl[2];
		echo gettext($table);
		exit();
	}
}
?>