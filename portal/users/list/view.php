<?php
/**
 *
 */
class view extends main_view  {
	public function config() {
		//------------------------------ global
		$this->global->page_title  = "person_list";

		//------------------------------ search form
		// $hidden = $this->form("#hidden")->value("xsearch");
		// $searchF = $this->form("text")->name("search")->label("search");
		// $submit = $this->form("submit")->value("search");
		// $search = array();
		// $search[] = $hidden->compile();
		// $search[] = $searchF->compile();
		// $search[] = $submit->compile();
		// $this->data->search = $search;

		// //------------------------------ list of person whit search
		// $person = $this->sql("#s_search");

		// $person
		// 	->addCol("detail","more")
		// 	->select(-1, "detail")->html($this->link("users/status=detail/id=%users_id%"))

		// 	->addCol("edit","edit")
		// 	->select(-1, "edit")->html($this->editLink("person"))
			
		// 	->removeCol(
		// 	"id,from,City_id,record_id,Absence_dateEducation_id,Education_group,Country_id,country,province_id,
		// 	casecode,casecode_old,type,en_name,en_family,en_father,third_name,third_family,
		// 	third_father,pasport_date,users_id,group,id,child,nationality,City_province_id");	
		
		// $this->data->person = $person->compile();
	}
}
?>