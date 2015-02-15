<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		//------------------------------ global
		$this->global->page_title = "price";

		$hidden = $this->form("#hidden")->value("reprot");
		$start_date =  $this->form("text")->name("start_date")->label("start_date")->date("date");
		$end_date =  $this->form("text")->name("end_date")->label("end_date")->date("date");
		$lists =  $this->form("select")->name("lists")->label("reports")->addClass("notselect");
		$submit = $this->form("#submitedit")->value("select");

		$list = $this->sql(".reports.rList", "price");


		foreach ($list as $key => $value) {
			$lists->child()->name($value['tables'])->label($value['name'])->value($value['tables']);
		}

		
		$reprot = array();
		
		$reprot[] = $hidden->compile();
		$reprot[] = $start_date->compile();
		$reprot[] = $end_date->compile();
		$reprot[] = $lists->compile();
		$reprot[] = $submit->compile();
		
		$this->data->report_list = $reprot;
		
	}
}
?>