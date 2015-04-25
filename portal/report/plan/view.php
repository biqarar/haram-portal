<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		//------------------------------ global
		$this->global->page_title = "classes";

		$hidden = $this->form("#hidden")->value("reprot");
		$lists =  $this->form("select")->name("lists")->label("reports");
		$submit = $this->form("#submitedit")->value("select");

		$list = $this->sql(".reports.rList", "classes");

		foreach ($list as $key => $value) {
			$lists->child()->name($value['tables'])->label($value['name'])->value($value['tables']);
		}

		
		$reprot = array();
		
		$reprot[] = $hidden->compile();
		$reprot[] = $lists->compile();
		$reprot[] = $submit->compile();
		
		$this->data->report_list = $reprot;

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