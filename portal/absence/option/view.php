<?php
/**
* @author Reza Mohiti <rm.biqarar@gmail.com>
*/
class view extends main_view {

	public function config() {

		//------------------------------ globals
		$this->global->page_title = "absence";

		//------------------------------ load form
		$f = $this->form("@absence", $this->urlStatus());

		$f->classification_id->attr['value'] = $this->xuId("classificationid");
		//------------------------------ edit form
		$this->sql(".edit", "absence", $this->xuId(), $f);


		//------------------------------ list of absence
		$list = $this->sql(".list", "absence", function($quey) {
			$quey->whereClassification_id($this->xuId("classificationid"));
		});

		$list->addCol("edit", "edit")
			->select(-1 , "edit")
			->html($this->editLink("absence"));

		$this->data->list = $list->compile();
	}
}
?>