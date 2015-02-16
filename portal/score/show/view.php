<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="show score classes";
		$classesid = $this->xuId("classesid");
		
		$this->classesDetail();
	}
}
?>