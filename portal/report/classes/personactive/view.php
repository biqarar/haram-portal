<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){


		$list = $this->sql("#classesactive");
		$this->global->url = config_lib::$url;
		$list['title'] = "گزارش کلاس های فعال ";
		if($this->xuId("xlsx") == 1) {
			$this->sql(".xlsx", $list, $list['title'], $start_date .'-'. $end_date);
		}
		$this->data->list = $list;
		
	}

}
?>