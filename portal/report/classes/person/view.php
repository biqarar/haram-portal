<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		// var_dump("fuck");exit();
		$list = $this->sql("#bridge_list", $this->xuId("classesid"));
		$list['title'] = "لیست مشخصات فراگیران";
		$this->data->list = $list;
		// ------------------------------ global
		
	}
}
?>