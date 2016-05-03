<?php
/**
 * @author REZA MOHITI <rm.biqarar@gmail.com>
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "search";
		$table = config_lib::$aurl[1];
		$this->global->usl = $table;
		$field = $this->sql("#getField", $table);
		$f= array();
		$search = array();
		$search[] = $hidden = $this->form("#hidden")->value("search")->compile();
		foreach ($field as $key => $value) {
			$search[] =  $this->form("text")->name($value)->label($value)->compile();
		}
		$search[]  = $this->form("#submitadd")->value("search");
		// $oldpasswd = $this->form("password")->name("oldpasswd")->label("oldpasswd");
		// $newpasswd = $this->form("password")->name("newpasswd")->label("newpasswd");
		// $repasswd =  $this->form("password")->name("repasswd")->label("repasswd");
		// $submit = $this->form("#submitedit")->value("update");
		// 
		// $search[] = $oldpasswd->compile();
		// $search[] = $newpasswd->compile();
		// $search[] = $repasswd->compile();
		// $search[] = $submit->compile();
		$f[] = $this->form("input")->name("s")->label("ssss");
		$this->data->search = $search;
		// var_dump($field);
		// var_dump("expression");
		// exit();
		
	}
}
?>