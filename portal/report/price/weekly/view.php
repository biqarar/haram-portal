<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		// var_dump("fuck");exit();
		$list = $this->sql("#weekly", $this->xuId("startdate"), $this->xuId("enddate"));
		$this->global->url = config_lib::$url;
		$list['title'] = "گزارش مالی  - هفتگی";
		if($this->xuId("xlsx") == 1) {
			$this->sql(".xlsx", $list, $list['title'], $this->xuId("startdate") .'-'. $this->xuId("enddate"));
		}
		$this->data->list = $list;
		// ------------------------------ global
		
	}
}
?>