<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */


class view extends main_view {

	public function config(){

		//------------------------------ global
		$this->global->page_title = "bridge";

	    $f = $this->form('@bridge', $this->urlStatus());

	    $f->users_id->value($this->xuId("usersid"));

	    if($this->urlStatus() == "edit"){
	    	$list_bridge = $this->sql("#list_bridge", $this->xuId("usersid"));
	    	$x = array();
	    	foreach ($list_bridge as $key => $value) {
	    		$x[$key] = $this->form('@bridge', $this->urlStatus());
	    		$this->sql(".edit", "bridge", $value['id'] , $x[$key]);
	    		// var_dump($value);

	    	}
	    		
	    }

	}
}
?>