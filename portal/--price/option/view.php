<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
		//------------------------------  global
		$this->global->page_title = "userprice";

		//------------------------------ set users id
		$usersid = ($this->xuId("usersid") != 0) ? $this->xuId("usersid") : $this->sql("#find_usersid", $this->xuId("id"));
		$this->global->usersid = $usersid;
		//------------------------------  url
		$this->global->url .=  "/usersid=" . $usersid;
		$this->global->status =  gettext($this->urlStatus()); 
		// var_dump($this->global->url);exit();
		
		$f = $this->form('@userprice', $this->urlStatus());
	
		$f->type->child(0)->checked("checked");
		$f->remove("status,value_back,classes_id");
		$f->title->child(0)->selected("selected");
		
		$this->sql(".edit", "userprice", $this->xuId(), $f);
	
		//------------------------------  set name and family
		$this->global->name = $this->sql(".assoc.foreign", "person", $usersid, "name", "users_id")
							 . " " . 
							 $this->sql(".assoc.foreign", "person", $usersid, "family", "users_id");
	}
}
?>