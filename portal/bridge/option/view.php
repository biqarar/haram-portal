<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "bridge";
		$this->global->url = $this->uStatus(true);
	    	$f = $this->form('@bridge', $this->uStatus());

	    	$this->sql(".edit", "bridge", $this->uId(), $f);
	}
}
?>