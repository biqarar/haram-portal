<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="classification";


		//------------------------------ get detail classes
		$this->classesDetail();
		

		$this->data->dataTable = $this->dtable("classification/status=api/classesid=" . $this->xuId("classesid").'/',
			array("learn","username", "name", "family", "date_entry", "date_delete", "because", "edit"));


		$this->data->classes_id = $this->data->list['list'][0]['id'];
	}
}
?>