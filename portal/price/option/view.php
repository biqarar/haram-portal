<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
		//------------------------------  global
		$this->global->page_title = "price";

		//------------------------------ set users id
		$usersid = ($this->xuId("usersid") != 0) ? $this->xuId("usersid") : $this->sql("#find_usersid", $this->xuId("id"));
		$this->global->usersid = $usersid;
		//------------------------------  url
		$this->global->url .=  "/usersid=" . $usersid;
		$this->global->status =  gettext($this->urlStatus()); 
		// var_dump($this->global->url);exit();
		
		$f = $this->form('@price', $this->urlStatus());
	
		$f->type->child(0)->checked("checked");
		$f->title->child(0)->selected("selected");
		$f->remove("status");
	
		$this->sql(".edit", "price", $this->xuId(), $f);
	
		//------------------------------  set name and family
		$this->global->name = $this->sql(".assoc.foreign", "person", $usersid, "name", "users_id")
							 . " " . 
							 $this->sql(".assoc.foreign", "person", $usersid, "family", "users_id");

		//------------------------------ load form


	}
}
?>