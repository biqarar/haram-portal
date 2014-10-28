<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'branch';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@branch", $this->uStatus());

		$this->sql(".edit", "branch", $this->uId(), $f);
		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "branch/edit/%id%")
		->attr("target", "_blank");
		$this->data->list = $this->sql(".list","branch")->addColEnd("edit", "edit")->select(-1, "edit")
		->html($c)->compile();

	}
}
?>