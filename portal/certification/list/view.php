<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{

	public function config(){
		//------------------------------ global
		$this->global->page_title = "certification";


		$this->data->dataTable = $this->dtable("certification/status=api/"
			, array(
			"more",
			"username",
			"name",
			"family",
			"plan",
			"mark",
			"date_request",
			"date_design",
			"date_print",
			"date_deliver"
				));
	}
}
?>