<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		//------------------------------  global
		$this->global->page_title = "users_detail";

		//------------------------------  set users_id
		$users_id  = $this->xuId();

		//------------------------------ check users (if teacher , can not be display another users by id)
		$this->check_users_type($users_id);

		//------------------------------  make person card
		$person = $this->sql(".list.card", "person", $users_id, "users_id");
		unset($person['addLink']);
		unset($person['editLink']);
		// unset($person['moreLink']);
			
		$person["moreLink"] = "teacher/person/status=detail/id=" . $users_id;
		$this->data->person = $person;


		//------------------------------  make bridge card
		$bridge = $this->sql("#bridge_detail" , $users_id);
		$new_bridge = array();
		$i = 1;
		foreach ($bridge as $key => $arrayValue) {
			if($i <= 5){
				$new_bridge["list"]['list'][0][$arrayValue['title']] = $arrayValue['value'];
			}
			$i++;
		}

		//------------------------------  make global of bridge card
		$new_bridge['title'] = "bridge";
		$new_bridge["addLink"] = "teacher/bridge/status=add/usersid=$users_id";
		$new_bridge["moreLink"] = "teacher/bridge/status=detail/usersid=$users_id";
		// $new_bridge["editLink"] = "bridge/status=edit/usersid=$users_id";
		
		$this->data->bridge = $new_bridge;


		//------------------------------  make teacher card (person extera)
		$person_extera =  $this->sql(".list.card", "person_extera" , $users_id , "users_id");
		if(isset($person_extera['list']['list'][0])){
			unset($person_extera['addLink']);
			$person_extera["editLink"] = "teacher/extera/status=edit/usersid=$users_id";
			$person_extera["moreLink"] = "teacher/extera/status=detail/usersid=$users_id";
			$this->data->person_extera = $person_extera;		
		}
	}
} 
?>