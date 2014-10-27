<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/

class view extends main_view{
	public function config(){
		$this->global->page_title='permission';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@permission", $this->uStatus());
		// $tables = $this->sql("#tables_list");
		$this->listBranch($f);
		$tables = scandir(sql);
		$black = array(".","..", "permission", "history", "login_counter","dev", "branch_users_key");
		foreach ($tables as $key => $value) {
			$value = preg_replace("/\.sql\.php$/", "", $value);
			if(preg_grep("/^$value$/", $black)) continue;
			$f->tables->child()->name($value)->label(_($value))->value($value);
		}
		$this->sql(".edit", "permission", $this->uId(), $f);
	}
}
?>