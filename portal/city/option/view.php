<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		//------------------------------ globals
		$this->global->page_title = 'city';

		//------------------------------  load form
		$f = $this->form("@city", $this->urlStatus());
		
		//------------------------------  list of city
		$list = $this->sql(".list", "city", function($query) {
			$query->joinProvince()->whereId("#city.province_id")->fieldName('Pname');
		})		
		->addColEnd("edit", "edit")->select(-1, "edit")
		->html($this->editLink("city"));
		
		$this->data->list = $list->compile();
		
		//------------------------------  edit form
		$this->sql(".edit", "city", $this->xuId(), $f);
	}
}
?>