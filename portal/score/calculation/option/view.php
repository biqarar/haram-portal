<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config() {
		//------------------------------ global
		$this->global->page_title='score_calculation';

		//------------------------------ load form
		$f = $this->form("@score_calculation", $this->urlStatus());

		//------------------------------ edit form
		$this->sql(".edit", "score_calculation", $this->xuId(), $f);

		//------------------------------ list of score_calculation
		$this->data->dataTable = $this->dtable("score/calculation/status=apilist/", array("id", "name","calculation", "status", "descripition", "edit"));
	}
}
?>