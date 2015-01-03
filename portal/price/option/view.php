<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
	
		$this->global->page_title = "price";
		$this->global->url = "status=add/usersid=" . $this->xuId("usersid");
		
		$f = $this->form('@price', $this->urlStatus());

		$this->sql(".edit", "price", $this->xuId(), $f);
	}
}
?>