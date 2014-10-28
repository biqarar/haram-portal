<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = "plan_section";
		$this->global->url = $this->uStatus(true, true);
		$f = $this->form("@plan_section", $this->uStatus(2));
		$this->sql(".edit", "plan_section", $this->uId(3), $f);
	}
}
?>