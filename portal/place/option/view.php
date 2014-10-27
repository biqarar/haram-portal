<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "place";
		$this->global->url = $this->uStatus(true);
		$f = $this->form('@place', $this->uStatus());
		$this->listBranch($f);
		$this->sql(".edit", "place", $this->uId(), $f);

		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "place/edit/%id%")
		->attr("target", "_blank");

		$this->data->list = $this->sql(".list","place")
		->addColEnd("edit","edit")->select(-1, "edit")->html($c)
		->compile();

	}
}
?>