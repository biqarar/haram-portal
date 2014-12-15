<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){

		//------------------------------ set global
		$this->global->page_title =_("person_extera edit");

			//------------------------------ url
		$this->global->url = ($this->xuId("status") == "add") ? 
				"usersid=" . $this->xuId("usersid") :
				"status=edit/usersid=" . $this->xuId("usersid"); 

		//------------------------------ if person extera exist can not be add another record
		$id = $this->sql("#person_extera_id", $this->xuId("usersid"));

		//------------------------------ load person_extera form
		$f = $this->form("@person_extera", (!$id) ? "add": "edit");

		$this->sql(".edit", "person_extera", $id , $f);
	}
}
?>