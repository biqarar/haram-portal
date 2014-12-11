<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'users_description';
		$this->global->url = $this->uStatus(true, true);
		$f = $this->form("@users_description", $this->uStatus(2));

		$this->sql(".edit", "users_description", $this->uId(3), $f);
	}
}
?>