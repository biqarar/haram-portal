<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/

class view extends main_view {

	public function config() {
		//------------------------------ global
		$this->global->page_title='permission';

		//------------------------------ load form
		$f = $this->form("@permission", $this->urlStatus());

		//------------------------------list of branch
		$this->listBranch($f);

		//------------------------------ make list of table whit .sql.php file in sql folder 
		$tables = scandir(sql);

		//------------------------------ other permission (no table)
		$other_permission = array(
			"teacher",
			"home",
			"report"
		);

		//------------------------------ push other permission to list of permission
		foreach ($other_permission as $key => $value) {
			array_push($tables, $value);
		}

		//------------------------------ this table not sohw in table list (system table)
		$black = array(".","..", "permission", "history", "login_counter","dev", "branch_users_key", "branch_cash", "student1");
		

		foreach ($tables as $key => $value) {
		
			$value = preg_replace("/\.sql\.php$/", "", $value);
		
			if(preg_grep("/^$value$/", $black)) continue;
		
			$f->tables->child()->name($value)->label(_($value))->value($value);
		}

		//------------------------------ edit form
		$this->sql(".edit", "permission", $this->xuId(), $f);

		//------------------------------ list of users pemission
		$permission_list = $this->sql(".list", "permission")
		->addCol("edit", "edit")
		->select(-1, "edit")
		->html($this->editLink("permission"))
		->compile();
		

		$this->data->list = $permission_list;
	}
}
?>