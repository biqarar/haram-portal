<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'remove Duplicate';
		$x = $this->sql("#duplicate", $this->xuId("nationalcode"));
		// var_dump($x);exit();
		$this->data->show = $x;
	}

}
?>