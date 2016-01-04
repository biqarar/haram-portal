<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view {

	public function config(){
		//------------------------------ global
		$this->global->page_title ="item";

		//------------------------------ load form
		$f = $this->form("@nezarat_item", $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ edit form
		if($this->urlStatus() == "edit") {
			$this->sql(".edit", "nezarat_item", $this->xuId(), $f);	
		}
	}
}
?>