<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{

	public function config(){
		//------------------------------ global
		$this->global->page_title = "classes";

		//------------------------------ edit link
		$edit = $this->tag("a")->addClass("xmore")
		->attr("href", "classes/status=edit/id=%id%")
		->attr("target", "_blank");
		
		//------------------------------ classification link
		$classification = $this->tag("a")->text("classification")
			->attr("href", "classification/classesid=%id%")
			->attr("target", "_blank");	

		//------------------------------ classes detail
		$show_more = $this->tag("a")->text("detail")
			->attr("href", "classes/status=detail/id=%id%")
			->attr("target", "_blank");

		//------------------------------ classes list
		$c = $this->sql(".classesDetail");

		$c->addCol("detail", "classes")
		->select(-1, "detail")
		->html($show_more)

		->addCol("classification","class")
		->select(-1, "classification")
		->html($classification);

		// ->addColEnd("edit", "edit")
		// ->select(-1, "edit")
		// ->html($edit);

		$this->data->list = $c->compile();
	}
}
?>