<?php
/**
 *
 */
class view extends main_view  {
	public function config() {
		$this->global->page_title  = "person_list";

		// search 
		$field = $this->sql("#getField","person");
		$farsi_field = array();
		foreach ($field as $key => $value) {
			$farsi_field[] = gettext($value);
		}
		$this->global->field = $farsi_field;
		$hidden = $this->form("#hidden")->value("xsearch");
		$searchF = $this->form("text")->name("search")->label("search");
		$submit = $this->form("submit")->value("search");
		$search = array();
		$search[] = $hidden->compile();
		$search[] = $searchF->compile();
		$search[] = $submit->compile();
		$this->data->search = $search;

		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "users/status=detail/id=%users_id%")
		->attr("target", "_blank");

		$edit = $this->tag("a")
		->text("اصلاح")
		// ->addClass("xmore")
		->attr("href", "person/status=edit/id=%id%")
		->attr("target", "_blank");
		$person = $this->sql("#s_search");
		$person->addCol("detail","more")
			->select(-1, "detail")->html($c)
			->addCol("edit","edit")
			->select(-1, "edit")->html($edit)
			->removeCol(
			"id,from,City_id,record_id,Absence_dateEducation_id,Education_group,Country_id,country,province_id,
			casecode,casecode_old,type,en_name,en_family,en_father,third_name,third_family,
			third_father,pasport_date,users_id,group,id,child,nationality,City_province_id");	
		// var_dump($person->compile());
		$this->data->person = $person->compile();
	}
}
?>