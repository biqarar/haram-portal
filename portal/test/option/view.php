<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->global->page_title = "group";
		$this->global->url = $this->uStatus(true);
		$f = $this->form('@group', $this->uStatus());

		$this->sql(".edit", "group", $this->uId(), $f);
		// $this->sql("#a");
		// exit();
		}
}
?>