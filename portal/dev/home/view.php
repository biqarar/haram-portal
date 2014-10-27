<?php
/*
*
*/
class view extends main_view {
	public function config() {
		$this->global->page_title  = "dev";

		$c = $this->tag("a")
		->text("edit")
		->attr("href", "dev/edit/%id%")
		->attr("target", "_blank");

		$adress = $this->tag("a")
		->text("%adress%")
		->attr("href", "%adress%")
		->attr("target", "_blank");

		$report_pic = $this->tag("img")
		->attr("src", "static/img/%report%.png")
		->addClass("avatarx");

		$repair_pic = $this->tag("img")
		->attr("src", "static/img/%repair%.png")
		->addClass("avatarx");

		$dev = $this->sql(".list", "dev", function ($query){

		})->addCol("detail","edit")
		->select(-1, "detail")->html($c)
		->select(-1, "adress")->html($adress)
		->select(-1, "report")->html($report_pic)
		->select(-1, "repair")->html($repair_pic);		
		$this->data->dev = $dev->compile();

	}
}
?>