<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title = "absence";

		//------------------------------ absence tag
		$absence_tag = $this->tag("input")->type("text")->date("date")->addClass("absence-date");

		//------------------------------ get detail classes
		$this->classesDetail();
			

			$this->data->dataTable = $this->dtable("absence/status=classeslist/classesid=" . $this->xuId("classesid").'/',
			array("name", "family", "date_entry", "date_delete", "type" ,"ثبت غیبت" , "ثبت غیبت بیشتر"));

		// $this->data->classes_id = $this->data->list['list'][0]['id'];


	}
}
?>