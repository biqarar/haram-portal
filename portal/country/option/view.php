<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title='country';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@country", $this->uStatus());

		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "country/edit/%id%")
		->attr("target", "_blank");

		$this->sql(".edit", "country", $this->uId(), $f);
		$list = $this->sql(".list", "country")->addColEnd("edit", "edit")->select(-1, "edit")
		->html($c)->compile();
		
		$this->data->list = $list;
	}
}
?>