<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'position';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@position", $this->uStatus());

		$this->sql(".edit", "position", $this->uId(), $f);
	}
}
?>