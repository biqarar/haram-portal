<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		// var_dump("fuck");exit();
		$list = $this->sql("#bridge_list", $this->xuId("classesid"));
		$list['title'] = "لیست شماره های تماس فراگیران";
		$this->global->url = config_lib::$url;
			$this->sql(".xlsx", $list, $list['title']);
		if($this->xuId("xlsx") == 1) {
		}
		$this->data->list = $list;
		// ------------------------------ global
		
	}
}
?>