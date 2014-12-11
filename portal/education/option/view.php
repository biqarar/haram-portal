<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {
	
	public function config(){
		//------------------------------ global
		$this->global->page_title = "education";

		//------------------------------ load form
		$f = $this->form("@education", $this->urlStatus());

		//------------------------------ edit form
		$this->sql(".edit", "education", $this->xuId(), $f);
		
		//------------------------------ lisf of education
		$education_list =  $this->sql(".list","education")
		->addCol("edit", "edit")
		->select(-1, "edit")
		->html($this->editLink("education"))
		->compile();

		$this->data->list = $education_list;

	}
}
?>