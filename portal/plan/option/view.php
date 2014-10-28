<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	
	public function config(){

		//------------------------------ globals
		$this->global->page_title ="plan";

		//------------------------------ load form
		$f = $this->form("@plan", $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ edit form
		$this->sql(".edit", "plan", $this->xuId(), $f);

		//------------------------------ edit link
		$edit = $this->tag("a")
		->addClass("xmore")
		->attr("href", "plan/status=edit/id=%id%");
		
		//------------------------------ list of plan
		$list_plan = $this->sql(".list","plan")->addColEnd("edit","edit")->select(-1, "edit")->html($edit)->compile();
		
		$this->data->list = $list_plan;		
	}
}
?>