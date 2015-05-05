<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	
	public function config(){

		//------------------------------ globals
		$this->global->page_title ="plan";

		//------------------------------ load form
		$f = $this->form("@plan", $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ edit form
		$this->sql(".edit", "plan", $this->xuId(), $f);
		
		//------------------------------ list of plan
		$this->data->dataTable = $this->dtable(
			"plan/status=api/", 
			array(
				"group_id",
				"name",
				"price",
				"absence",
				"certificate",
				"mark",
				"min_person",
				"max_person",
				"expired_price",
				"payment_count",
				"edit"));
	}
}
?>