<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'users_branch';
		$this->global->url = $this->uStatus(true, true);
		$f = $this->form("@users_branch", $this->uStatus(2));

		$this->sql(".edit", "users_branch", $this->uId(3), $f);
	}
}
?>