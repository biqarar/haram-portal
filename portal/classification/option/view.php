<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ globals
		$this->global->page_title ="classification";

		//------------------------------ load form
		$f = $this->form("@classification", $this->urlStatus());
		// var_dump($f);exit();
		// unset($f->plan_section_id);
		// unset($f->mark);

		//------------------------------ edit form
		if($this->urlStatus() == "edit") {
			$this->sql(".edit", "classification", $this->xuId(), $f);

			//------------------------------ set name and family instead users_id
			$name = $this->sql(".assoc.foreign", "person", $f->users_id->attr['value'] ,"name", "users_id");
			$family = $this->sql(".assoc.foreign", "person", $f->users_id->attr['value'] ,"family", "users_id");
			$f->users_id->value($name . ' ' . $family);
			
			//------------------------------ set plan name and course name instead plan & course id
			$plan_id = $this->sql(".assoc.foreign", "classes", $f->classes_id->attr['value'], "plan_id");
			// $course_id = $this->sql(".assoc.foreign", "classes", $f->classes_id->attr['value'], "course_id");
			
			$plan  = $this->sql(".assoc.foreign", "plan" , $plan_id , "name");
			// $course = $this->sql(".assoc.foreign", "course", $course_id, "name");

			$f->classes_id->value($plan);
		}
	}
}
?>