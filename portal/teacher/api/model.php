<?php 
/**
* 
*/
class model extends main_model
{
	public function post_list() {

		$sql = $this->sql()->tablePerson()
		->condition("or" , "##concat(name, family, father)" , "like" , "%" . $this->xuId("search") . "%");
		// $sql->fieldName("name")->fieldFamily("family")->fieldFather("father");//->fieldUsersid("id");
// 
		$sql->joinUsers()->whereId("#person.users_id")->andType("teacher")->fieldUsername();
		// $sql->condition("or", "##users.username" , "=" ,$this->xuId("search"));
		
		$sql = $sql->limit(10)->select();
		$array = array();
		ilog($sql->string());
		foreach ($sql->allAssoc() as $key => $value) {
			$array[] = array(
				"value" => $value['name'].' '.$value['family'],
				"id" =>  $value['users_id']

				);
		}
		
		debug_lib::msg("list", $array);

	}
}
?>