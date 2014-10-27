<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->global->page_title ="classification";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@classification", $this->uStatus());
		$this->sql(".edit", "classification", $this->uId(), $f);
	}
}
?>