<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config() {
		//------------------------------ global
		$this->global->page_title='file_tag';

		//------------------------------ load form
		$f = $this->form("@file_tag", $this->urlStatus());

		//------------------------------ edit form
		$this->sql(".edit", "file_tag", $this->xuId(), $f);
		//------------------------------ list of country
		$this->data->dataTable = $this->dtable("files/type=tag/status=api/", array("id","tag", "table_name"));
	}
}
?>