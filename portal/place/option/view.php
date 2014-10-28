<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {
		//------------------------------ global
		$this->global->page_title = "place";

		//------------------------------ load form
		$f = $this->form('@place', $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ remove branch_id because list of branch loaded
		$f->remove("branch_id");
		
		//------------------------------ edit form
		$this->sql(".edit", "place", $this->xuId(), $f);

		//------------------------------ edit link
		$c = $this->tag("a")->addClass("xmore")
		->attr("href", "place/status=edit/id=%id%")
		->attr("target", "_blank");

		//------------------------------ list of place
		$this->data->list = $this->sql(".list","place")
		->addColEnd("edit","edit")->select(-1, "edit")->html($c)
		->compile();

	}
}
?>