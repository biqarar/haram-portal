<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){

		//------------------------------- global
		$this->global->page_title = "education_users";

		//------------------------------ url
		$this->global->url = ($this->xuId("status") == "add") ? 
				"usersid=" . $this->xuId("usersid") :
				"status=edit/id=" . $this->xuId();

		//------------------------------- load form
		$f = $this->form("@education_users", $this->urlStatus());

		//------------------------------- edit form
		$this->sql(".edit", "education_users", $this->xuId(), $f);
	}
}
?>