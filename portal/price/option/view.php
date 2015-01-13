<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
		//------------------------------  global
		$this->global->page_title = "price";

		//------------------------------ set users id
		$usersid = $this->xuId("usersid");

		//------------------------------  url
		$this->global->url = "status=add/usersid=" . $usersid;
		
		//------------------------------  set name and family
		$this->global->name = $this->sql(".assoc.foreign", "person", $usersid, "name", "users_id")
							 . " " . 
							 $this->sql(".assoc.foreign", "person", $usersid, "family", "users_id");

		//------------------------------ load form
		$f = $this->form('@price', $this->urlStatus());
		// $f->remove("title");
		// var_dump($f);exit();

		// $this->sql(".edit", "price", $this->xuId(), $f);
	}
}
?>