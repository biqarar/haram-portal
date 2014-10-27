<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'pending_classes';
		$this->global->url = $this->uStatus(true, true);
		$f = $this->form("@pending_classes", $this->uStatus(2));

		$this->sql(".edit", "pending_classes", $this->uId(3), $f);
	}
}
?>