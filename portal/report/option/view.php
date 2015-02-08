<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'report';

		//------------------------------ load form
		$f = $this->form("@report", $this->urlStatus());

		//------------------------------ list of report
		$this->data->dataTable = $this->dtable(
			"report/status=api/", 
			array("id", "table", "name", "url", "edit"));

		// $this->data->list = $list->compile();
		//------------------------------ edit form
		$this->sql(".edit", "report", $this->xuId(), $f);
	}

}
?>