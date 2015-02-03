<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		//------------------------------ global
		$this->global->page_title = "classes";

		$this->data->dataTable = $this->dtable("report/classes/status=apilist/"
			, array(
				"id",
				"plan",
				_("name") . ' ' . _("teacher"),
				_("family") . ' ' . _("teacher"),
				"place",
				"age_range",
				"start_time",
				"end_time",
				"capacity",
				"count",
				"select",
				"detail"
				));
	}
}
?>