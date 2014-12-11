<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		//------------------------------ globals
		$this->global->page_title = 'form_questions';
		$x =  ($this->urlStatus() == "edit") ? "/id=" . $this->xuId() : "";
		$this->global->url = "/status=" . $this->urlStatus() .$x;
		//------------------------------  load form
		$f = $this->form("@form_questions", $this->urlStatus());
		
		//------------------------------  list of form_questions
		$list = $this->sql(".list", "form_questions", function($query) {
			// var_dump($query);
		})		
		->addColEnd("edit", "edit")->select(-1, "edit")
		->html($this->link("formmaker/questions/status=edit/id=%id%"));
		// var_dump($list->compile());
		$this->data->list = $list->compile();
		
		//------------------------------  edit form
		$this->sql(".edit", "form_questions", $this->xuId(), $f);
	}
}
?>