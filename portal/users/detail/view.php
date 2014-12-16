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
		$person["editLink"] = "person/status=edit/id=" . $person['list']['list'][0]['id'];
		$this->data->person = $person;


		//------------------------------  make users card
		$users = $this->sql(".list.card", "users", $users_id, "id");
		unset($users['addLink']);
		// unset($users['editLink']);
		unset($users['moreLink']);
		unset($users['list']['list'][0]['password']);
		$this->data->users = $users;

		//------------------------------  make oldprice card
		$oldprice = $this->sql(".list.card", "oldprice", $users_id, "users_id");
		unset($oldprice['addLink']);
		unset($oldprice['editLink']);
		$this->data->oldprice = $oldprice;


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
		$new_bridge["addLink"] = "bridge/status=add/usersid=$users_id";
		$new_bridge["moreLink"] = "bridge/status=detail/usersid=$users_id";
		$new_bridge["editLink"] = "bridge/status=edit/usersid=$users_id";
		
		$this->data->bridge = $new_bridge;


		//------------------------------  make teacher card (person extera)
		$person_extera =  $this->sql(".list.card", "person_extera" , $users_id , "users_id");
		unset($person_extera['addLink']);
		$person_extera["editLink"] = "person/extera/status=edit/usersid=$users_id";
		$person_extera["moreLink"] = "person/extera/status=detail/usersid=$users_id";

		$this->data->person_extera = $person_extera;


		//------------------------------  make bridge card
		$query_olddb = $this->sql("#olddb" , $users_id);
		if(!empty($query_olddb)){
			$olddb = array();
			$i = 1;
			foreach ($query_olddb as $key => $arrayValue) {
				if($key != "student"){
					$c = "&nbsp&nbspتعداد&nbsp&nbsp";
					$m = "&nbsp&nbspمورد&nbsp&nbsp";
				}else{
					$c = "";	
					$m = "";
				}
				$olddb["list"]['list'][0][$key] =
				 "<a>".$c .  $arrayValue . $m ."&nbsp&nbsp&nbsp&nbsp</a>"
				."<a href='olddb/" .$key . '/id='. $query_olddb['student'] . "'>نمایش کامل اطلاعات</a>";
				$i++;
					
			}
			
			//------------------------------  make global of bridge card
			$olddb['title'] = "olddb";
			// $olddb["moreLink"] = "olddb/status=detail/usersid=$users_id";
			$this->data->olddb = $olddb;
		}

	}
} 
?>