<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		//------------------------------ globals
		$this->global->page_title = 'form_group_item';
		$x =  ($this->urlStatus() == "edit") ? "/id=" . $this->xuId() : "";
		$this->global->url = "/status=" . $this->urlStatus() .$x;
		//------------------------------  load form
		$f = $this->form("@form_group_item", $this->urlStatus());
		
		//------------------------------  list of form_group_item
		$list = $this->sql(".list", "form_group_item", function($query) {
			// var_dump($query);
		})		
		->addColEnd("edit", "edit")->select(-1, "edit")
		->html($this->link("formmaker/groupitem/status=edit/id=%id%"));
		// var_dump($list->compile());
		$this->data->list = $list->compile();
		
		//------------------------------  edit form
		$this->sql(".edit", "form_group_item", $this->xuId(), $f);
	}
}
?>