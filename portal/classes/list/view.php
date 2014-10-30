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
		$classes_detail = $this->sql(".list", "classes", function($query) {
			$query->limit(80);
		})

		->addCol("detail", "classes")
		->select(-1, "detail")
		->html($show_more)

		->addCol("classification","class")
		->select(-1, "classification")
		->html($classification)

		->compile();

		if(isset($classes_detail['list'])){	
				foreach ($classes_detail ['list'] as $key => $value) {
					$classes_detail ['list'][$key]['plan_id']   = $this->sql(".assoc.foreign", "plan", $value["plan_id"], "name");
					$classes_detail ['list'][$key]['course_id'] = $this->sql(".assoc.foreign", "course", $value["course_id"], "name");
					$classes_detail ['list'][$key]['teacher']   = $this->sql(".assoc.foreign", "person", $value["teacher"], "family", "users_id");
					$classes_detail ['list'][$key]['place_id']  = $this->sql(".assoc.foreign", "place", $value["place_id"], "name");
				}	
		}

		// ->addColEnd("edit", "edit")
		// ->select(-1, "edit")
		// ->html($edit);

		$this->data->list = $classes_detail;
	}
}
?>