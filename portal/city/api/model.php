<?php
class model extends main_model{
	/**
	* return list of city in province
	*/
	public function post_list(){
		$sql = $this->sql()->tableCity()->whereProvince_id(config_lib::$aurl[2])->select();
		debug_lib::msg("city", $sql->allAssoc());
	}
}
?>