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
				"status=edit/id=" . $this->xuId(); 

		//------------------------------ load person_extera form
		$f = $this->form("@person_extera", $this->urlStatus());
	}
}
?>