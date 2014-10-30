<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'branch';

		//------------------------------ load form
		$f = $this->form("@branch", $this->urlStatus());

		//------------------------------ list of branch
		$this->data->list = $this->sql(".list","branch")->addColEnd("edit", "edit")->select(-1, "edit")
		->html($this->editLink("branch"))->compile();

		//------------------------------ edit form
		$this->sql(".edit", "branch", $this->xuId(), $f);
	}
}
?>