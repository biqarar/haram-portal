<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title = "racehistory";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@racehistory", $this->uStatus());

		$this->sql(".edit", "racehistory", $this->uId(), $f);
	}
}
?>