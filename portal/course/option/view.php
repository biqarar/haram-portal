<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		//------------------------------ globals
		$this->global->page_title='course';

		//------------------------------ locad form
		$f = $this->form("@course", $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ remove branch_id because list of branch is loaded
		$f->remove("branch_id");
		
		//------------------------------ edit form
		$this->sql(".edit", "course", $this->xuId(), $f);

		//------------------------------ list of course
		$this->data->list = $this->sql(".list","course")
			->addColEnd("edit","edit")->select(-1, "edit")->html($this->editLink("course"))
			->compile();
		
	}
}
?>