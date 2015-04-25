<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){

		//------------------------------  global
		$this->global->page_title = "وضعیت شهریه های کلاس";

		$this->classesDetail();
		//------------------------------ set users id

		$this->data->dataTable = $this->dtable("price/status=classeslist/classesid=" . $this->xuId("classesid").'/',
			array("username", "name", "family", "date_entry", "date_delete", "because",  "موجودی فعال" , "more"));


		// $this->data->classes_id = $this->data->list['list'][0]['id'];
	}
}
?>