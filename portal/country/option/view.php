<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config() {
		//------------------------------ global
		$this->global->page_title='country';

		//------------------------------ load form
		$f = $this->form("@country", $this->urlStatus());

		//------------------------------ edit form
		$this->sql(".edit", "country", $this->xuId(), $f);

		//------------------------------ list of country
		$list = $this->sql(".list", "country")->addColEnd("edit", "edit")->select(-1, "edit")
		->html($this->editLink("country"))->compile();
		
		$this->data->list = $list;
	}
}
?>