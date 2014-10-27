<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title = 'city';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@city", $this->uStatus());
		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "city/edit/%id%")
		->attr("target", "_blank");

		$this->sql(".edit", "city", $this->uId(), $f);
		$list = $this->sql(".list", "city", function($query) {
			$query->joinProvince()->whereId("#city.province_id");
			// var_dump($query);
		})		
		->addColEnd("edit", "edit")->select(-1, "edit")
		->html($c);
		// var_dump($list->compile());
		$this->data->list = $list->compile();
	}
}
?>