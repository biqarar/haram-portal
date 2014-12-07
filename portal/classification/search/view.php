<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {


		$classes_id = isset(config_lib::$surl['classesid']) ? config_lib::$surl['classesid'] : 0;

		$this->global->classesid = $classes_id;
		
		//------------------------------ search form
		$hidden = $this->form("#hidden")->value("xsearch");
		$searchF = $this->form("text")->name("search")->label("search");
		$submit = $this->form("submit")->value("search");
		$search = array();
		$search[] = $hidden->compile();
		$search[] = $searchF->compile();
		$search[] = $submit->compile();
		$this->data->search = $search;

		//------------------------------ classification link
		$classification = $this->tag("span")->text('ثبت در کلاس')->addClass("ajxClassification xbtn xbtn-primary")
		->attr("xhref", "classification/api/usersid=%users_id%/classesid=" . $classes_id)
		->attr("xxxhref", "classification/classesid=" . $classes_id);		

		//------------------------------ seach into person table
		$person = $this->sql("#s_search");
		$person
		
			->addCol("classification","کلاس بندی")
			->select(-1, "classification")->html($classification)
		
			->removeCol(
			"id,from,City_id,record_id,Absence_dateEducation_id,Education_group,Country_id,country,province_id,
			casecode,casecode_old,type,en_name,en_family,en_father,third_name,third_family,
			third_father,pasport_date,users_id,group,id,child,nationality,City_province_id");	

		$this->data->person = $person->compile();

	}
}
?>