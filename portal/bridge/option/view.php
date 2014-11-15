<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */


class view extends main_view {

	public function config(){

		//------------------------------ global
		$this->global->page_title = "bridge";

	    $f = $this->form('@bridge', $this->urlStatus());
	    if($this->urlStatus() == "edit"){
	    	$this->sql(".edit", "bridge", $this->xuId(), $f);
	    }

	}
}
?>