<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'users_group';
		$this->global->url = $this->uStatus(true, true);
		$f = $this->form("@users_group", $this->uStatus(2));

		$this->sql(".edit", "users_group", $this->uId(3), $f);
	}
}
?>