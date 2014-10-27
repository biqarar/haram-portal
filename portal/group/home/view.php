<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "group";

		$edit = $this->tag("a")
		->addClass("xmore")
		->attr("href", "group/edit/%id%");
		$this->data->list = $this->sql(".list","group")
		->addColEnd("edit","edit")->select(-1, "edit")->html($edit)
		->compile();
	}
}
?>