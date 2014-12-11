<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->global->page_title = "price";
		$this->global->url = $this->uStatus(true);
		$f = $this->form('@price', $this->uStatus());

		$this->sql(".edit", "price", $this->uId(), $f);
	}
}
?>