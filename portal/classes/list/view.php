<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "classes";
		$edit = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "classes/status=edit/id=%id%")
		->attr("target", "_blank");
		
		$classification = $this->tag("a")
			->text("classification")
			->attr("href", "classification/%id%")
			->attr("target", "_blank");	
		$show_more = $this->tag("a")
			->text("detail")
			->attr("href", "classes/status=detail/id=%id%")
			->attr("target", "_blank");
		$c = $this->sql(".classesDetail");
		// $classes = $this->sql(".list","classes", function($query) {
		// 	$query->foreignCourse_id();
		// 	$query->foreignPlan_id();
		// 	$query->foreignPlace_id();

		// })->removeCol("
		// id,
		// course_id,
		// plan_id,
		// place_id,
		// teacher,
		// status,
		// type,
		// begin_time,
		// expert,
		// branch_id,
		// Course_end_time,
		// Course_expert,
		// Branch_id,
		// Group_id,
		// plan_price,
		// plan_certification,
		// plan_mark,
		// plan_rule,
		// plan_min_person,
		// plan_max_person,
		// plan_description,
		// Plan_price,
		// Plan_certification,
		// Plan_mark,
		// Plan_rule,
		// Plan_min_person,
		// Plan_max_person,
		// Plan_description,
		// Course_id,
		// Plan_absence,
		// Place_description,
		// Place_id,
		// Branch_id,
		// group_id
		// price,
		// absence,
		// certificate,
		// mark,
		// rule,
		// Course_begin_time,
		// group_id,
		// description,
		// Course_branch_id,
		// Plan_id,
		// Plan_group_id,
		// Plan_certificate,
		// Place_branch_id,
		// price,
		// min_person,
		// max_person")
		$c->addCol("detail", "classes")->select(-1, "detail")->html($show_more)
		->addCol("classification","class")->select(-1, "classification")->html($classification)
		->addColEnd("edit", "edit")->select(-1, "edit")->html($edit);
		$this->data->list = $c->compile();
		// var_dump($this->data->list);
	}
}
?>