<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="score";

		$this->global->score_type = $this->sql("#score_type", $this->xuId("scoretypeid"), "title");

		$this->classesDetail();
		

		$this->data->dataTable = $this->dtable(
			"score/classes/status=apilist/classesid=" . $this->xuId("classesid")
			.'/scoretypeid=' . $this->xuId("scoretypeid") . "/",
			array("name", "family", "نمره " . $this->global->score_type));


		$this->data->classes_id = $this->data->list['list'][0]['id'];
	}
}
?>