<?php
class model extends main_model{
	/**
	* return list of city in province
	*/
	public function post_list(){

		$sql = $this->sql()->tableCity()->likeName("%".$this->xuId("search")."%")->orlike("##province.name","%".$this->xuId("search")."%" );
		$sql->joinProvince()->whereId("#city.province_id")->fieldName("pname");
		$r = $sql->select();
		// echo ($r->string());
		// var_dump("expression");exit();
		$array = array();
		foreach ($r->allAssoc() as $key => $value) {
			$array[] = array(
				"value" => $value['pname'].' - '.$value['name'],
				"id" =>  $value['id']

				);
		}
		debug_lib::msg("list", $array);
	}
}
?>