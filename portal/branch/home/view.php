<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "branch";
		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "branch/edit/%id%")
		->attr("target", "_blank");
		$this->data->list = $this->sql(".list","branch")->addColEnd("view", "more")->select(-1, "view")
		->html($c)->compile();
	}
}
?>