<?php
class query_classesDetail_cls extends query_cls
{
	public function config($classes_id = false)	{
		return $this->sql(".list","classes", function($query,$classes_id) {
			$query->foreignCourse_id();
			$query->foreignPlan_id();
			$query->foreignPlace_id();
			// $query->whereId($classes_id);
			// var_dump($query);
		},$classes_id)->removeCol("
		id,
		course_id,
		plan_id,
		place_id,
		teacher,
		status,
		type,
		begin_time,
		expert,
		branch_id,
		Course_end_time,
		Course_expert,
		Branch_id,
		Group_id,
		plan_price,
		plan_certification,
		plan_mark,
		plan_rule,
		plan_min_person,
		plan_max_person,
		plan_description,
		Plan_price,
		Plan_certification,
		Plan_mark,
		Plan_rule,
		Plan_min_person,
		Plan_max_person,
		Plan_description,
		Course_id,
		Plan_absence,
		Place_description,
		Place_id,
		Branch_id,
		group_id
		price,
		absence,
		certificate,
		mark,
		rule,
		Course_begin_time,
		group_id,
		description,
		Course_branch_id,
		Plan_id,
		Plan_group_id,
		Plan_certificate,
		Place_branch_id,
		price,
		min_person,
		max_person");
	}
}
?>