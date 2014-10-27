<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title = 'group';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@group", $this->uStatus());
		
		$edit = $this->tag("a")
		->addClass("xmore")
		->attr("href", "group/edit/%id%");
		
		$this->sql(".edit", "group", $this->uId(), $f);
		$this->listBranch($f);
		// var_dump($f);
		// exit();
		$this->data->list = $this->sql(".list","group")
		->addColEnd("edit","edit")->select(-1, "edit")->html($edit)
		->compile();
		
	}
}
?>