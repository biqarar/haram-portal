<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title = 'province';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@province", $this->uStatus());

		$this->sql(".edit", "province", $this->uId(), $f);
	}
}
?>