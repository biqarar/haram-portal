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

		//------------------------------  make person card
		$person = $this->sql(".list.card", "person", $users_id, "users_id");
		unset($person['addLink']);
		$person["editLink"] = "person/status=edit/id=" . $person['list']['list'][0]['id'];
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

		//------------------------------  make global card
		$new_bridge['title'] = "bridge";
		$new_bridge["addLink"] = "bridge/status=add/usersid=$users_id";
		$new_bridge["moreLink"] = "bridge/status=detail/usersid=$users_id";
		
		$this->data->bridge = $new_bridge;

		//------------------------------  make old student table card
		$student1 =  $this->sql(".list.card", "student1" , $users_id , "users_id");
		unset($student1['addLink']);
		unset($student1['editLink']);

		$this->data->student1 = $student1;

	}
} 
?>