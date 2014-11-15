<?php 
/**
* 
*/
class model extends main_model {
	public function config() {
		
	}

	public function sql_users_detail($id = false) {
		$return = array();
		$users = $this->sql()->tableUsers()->whereId($id)->limit(1)->select();
		if($users->num() == 1) {
			$return[0] = $users->assoc();
			$return[1] = $this->sql()->tablePerson()->whereUsers_id($return[0]['id'])->limit(1)->select()->assoc();
			$return[2] = $this->sql()->tableStudent1()->whereUsers_id($return[0]['id'])->limit(1)->select()->assoc();
			// var_dump($return);
			return $return;
		}else{
			return array();
		}
		
	}

	public function sql_bridge_detail($users_id = false) {
		$bridge = $this->sql()->tableBridge()->whereUsers_id($users_id)->select()->allAssoc();
		return $bridge;
	}
}
?>