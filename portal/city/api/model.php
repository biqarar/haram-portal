<?php
class model extends main_model{
	/**
	* return list of city in province
	*/
	public function post_list(){

		$sql = $this->sql()->tableCity()->likeName("%".$this->xuId("search")."%");
		$sql->joinProvince()->whereId("#city.province_id")->fieldName("pname");
		$r = $sql->select();
		debug_lib::msg("city", $r->allAssoc());
	}
}
?>