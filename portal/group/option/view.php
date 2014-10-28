<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	
	public function config(){
		//------------------------------ globals
		$this->global->page_title = 'group';

		//------------------------------ load form
		$f = $this->form("@group", $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ edit link
		$edit = $this->tag("a")->addClass("xmore")->attr("href", "group/status=edit/id=%id%");

		
		//------------------------------ edit form
		$this->sql(".edit", "group", $this->xuId(), $f);

		//------------------------------ list of group
		$this->data->list = $this->sql(".list","group")
			->addColEnd("edit","edit")->select(-1, "edit")->html($edit)
			->compile();
		
	}
}
?>