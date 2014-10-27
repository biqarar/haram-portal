<?php
/**
* @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
*/
class view extends main_view {
	public function config() {
		$this->global->page_title = "absence";
		$this->global->url = $this->uStatus(true); // add | edit 
		$f = $this->form("@absence", $this->uStatus());

		$this->sql(".edit", "absence", $this->uId(), $f);

	}
}
?>