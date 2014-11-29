<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		//------------------------------ globals
		$this->global->page_title = 'form_group';

		$this->global->url = "/status=" . $this->urlStatus() . "/id=" . $this->xuId();
		//------------------------------  load form
		$f = $this->form("@form_group", $this->urlStatus());
		
		//------------------------------  list of form_group
		$list = $this->sql(".list", "form_group", function($query) {
			// var_dump($query);
		})		
		->addColEnd("edit", "edit")->select(-1, "edit")
		->html($this->link("formmaker/group/status=edit/id=%id%"));
		
		$this->data->list = $list->compile();
		
		//------------------------------  edit form
		$this->sql(".edit", "form_group", $this->xuId(), $f);
	}
}
?>