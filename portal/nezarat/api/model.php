<?php
class model extends main_model{
	/**
	* return list of nezarat in province
	*/
	public function post_list(){
		var_dump("fuck");exit();
		$sql = $this->sql()->tableNezarat_program()->likeTitle("%".$this->xuId("search")."%");
		$r = $sql->limit(10)->select();
		// var_dump($r->string());
		// var_dump("expression");exit();
		$array = array();
		foreach ($r->allAssoc() as $key => $value) {
			$array[] = array(
				"value" => $value['title'].' - '.$value['title'],
				"id" =>  $value['id']

				);
		}
		// var_dump($array);exit();
		debug_lib::msg("list", $array);
	}
}
?>