<?php
/**
* @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
*/
class view extends main_view {
	public function config() {
		$this->global->page_title = "regulation";
		$this->global->regulation = nl2br($this->sql("#regulation"));

	}
}
?>