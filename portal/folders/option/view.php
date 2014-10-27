<?php
/**
 * @author reza mohtit <rm.biqarar@gmail.com>
 */
class view extends main_view{
	public function config(){
		$this->global->page_title = "folders";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@folders", $this->uStatus());

		$this->sql(".edit", "folders", $this->uId(), $f);
	}
}
?>