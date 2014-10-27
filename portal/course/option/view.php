<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title='course';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@course", $this->uStatus());
		$this->listBranch($f);
		$this->sql(".edit", "course", $this->uId(), $f);

		$edit = $this->tag("a")
		->addClass("xmore")
		->attr("href", "course/edit/%id%");
		$this->data->list = $this->sql(".list","course")
		->addColEnd("edit","edit")->select(-1, "edit")->html($edit)
		->compile();
		
	}
}
?>