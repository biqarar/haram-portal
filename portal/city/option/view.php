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
		$this->data->dataTable = $this->dtable(
			'city/status=api/',
			array('id', 'name', 'province','edit')
			);
		//------------------------------  list of city
		$list = $this->sql(".list", "city", function($query) {
			$query->joinProvince()->whereId("#city.province_id")->fieldName('Pname');
		});


		$list = $this->editCol("city", $list, $this->editLink("city"));

		
		$this->data->list = $list->compile();
		
		//------------------------------  edit form
		$this->sql(".edit", "city", $this->xuId(), $f);
	}
}
?>