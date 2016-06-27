<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'نتایج مسابقه';
		$header = array(
			"شماره",
			"مسابقات تیمی",
			"تیم",
			"تعداد مسابقه",
			"تعداد برد ",
			"تعداد باخت",
			"تعداد مساوی",
			"میانگین درصد",
			"امتیاز",
			"بیشتر"
			);

		$list = $this->sql("#result", $this->xuId());

		$this->data->result = array("header" => $header, "list" => $list);
		// var_dump($this->xuId());exit();
		
	}

}
?>