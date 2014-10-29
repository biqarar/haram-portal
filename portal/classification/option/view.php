<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ globals
		$this->global->page_title ="classification";

		//------------------------------ load form
		$f = $this->form("@classification", $this->urlStatus());

		//------------------------------ edit form
		$this->sql(".edit", "classification", $this->xuId(), $f);
	}
}
?>