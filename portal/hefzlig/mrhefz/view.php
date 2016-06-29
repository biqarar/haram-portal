<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'آقای حفظ';
		$header = array(
			"مسابقات تیمی",
			"نام",
			"نام خانوادگی",
			"جمع امتیاز"
			);

		$list = $this->sql("#mrhefz", $this->xuId());

		$this->data->result = array("header" => $header, "list" => $list);
		// var_dump($this->xuId());exit();
		
	}

}
?>