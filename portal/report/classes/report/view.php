<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		// var_dump("fuck");exit();
		$list = $this->sql("#list", $this->xuId("classesid"));
		$this->data->list = $list;
		// ------------------------------ global
		
	}
}
?>