<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ globals
		$this->global->page_title ="return classes";
		// var_dump($this->xuId());
		$this->global->because = _($this->sql("#classification_detail","because", $this->xuId()));
		$this->global->date_delete = $this->sql("#classification_detail","date_delete", $this->xuId());
		$this->global->classification_id = $this->xuId();
		#classification/api/usersid="+usersid+"/classesid="+classesid
		$this->global->classesid = $this->sql("#classification_detail","classes_id", $this->xuId());
		$this->global->usersid = $this->sql("#classification_detail","users_id", $this->xuId());
		// var_dump($this->global->classesid,$this->global->usersid);exit();
		// var_dump($this->global->classesid,$this->global->usersid);exit();
		//------------------------------ load form
		$f = $this->form("@classification", $this->urlStatus());
		$f->remove("plan_section_id,mark");
		// var_dump($f);exit();
		// unset($f->plan_section_id);
		// unset($f->mark);

		//------------------------------ edit form
		if($this->urlStatus() == "edit") {
			//------------------- check branch
			$this->sql(".branch.classification", $this->xuId());
			
			$this->sql(".edit", "classification", $this->xuId(), $f);
			$this->data->users_id = $f->users_id->attr['value'];
			$this->data->classes_id =$f->classes_id->attr['value'];
			$this->data->id = $this->xuId();
			
			if($f->date_delete->attr['value'] != "") {
				//----------------------------- return to classes


			}else{
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
}
?>