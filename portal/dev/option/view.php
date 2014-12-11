<?php
/**
 * @author REZA MOHITI <rm.biqarar@gmail.com>
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "developer";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@dev", $this->uStatus());
		$this->sql(".edit", "dev", $this->uId(), $f);
	}
}
?>