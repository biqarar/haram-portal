<?php
class query_classesDetail_cls extends query_cls
{
	public function config($classesid = false){
		
		//------------------------------ get detail classes
		if($classesid){
			$return = array();

			$return['classesid'] = $classesid;

			$classes_detail = $this->sql(".list" , "classes", function ($query, $classesid) {
				$query->whereId($classesid);
			}, $classesid)->removeCol("meeting_no,start_date,end_date")

			//------------------------------ print link
			->addCol("print", "print")
			->select(-1, "print")
			->html(
				$this->tag("a")
				->href("classification/printlist/classesid=%id%")
				->class("icoletters a-undefault"))

			->compile();
			
			//------------------------------ change users id to name and family to show
			$classes_detail = $this->detailClasses($classes_detail);
			
			$return['page_title']
				 = gettext("class").' '.
				$classes_detail['list'][0]['plan_id'] . ' استاد ' .
				$classes_detail['list'][0]['teacher'] . ' ' .
				$classes_detail['list'][0]['place_id'] ;
			
			$return['list'] = $classes_detail;

			return $return;
	}
}

	/**
	*	some field in the classes table must be change (foreign) to other field in other table
	*/
	public function detailClasses($classes_detail = false) {
		if(isset($classes_detail['list'])){	
			foreach ($classes_detail ['list'] as $key => $value) {
				$classes_detail ['list'][$key]['plan_id']   = $this->sql(".assoc.foreign", "plan", $value["plan_id"], "name");
				// $classes_detail ['list'][$key]['course_id'] = $this->sql(".assoc.foreign", "course", $value["course_id"], "name");
				$classes_detail ['list'][$key]['teacher']   = 
				$this->sql(".assoc.foreign", "person", $value["teacher"], "name", "users_id") . ' ' . 
				$this->sql(".assoc.foreign", "person", $value["teacher"], "family", "users_id");
				$classes_detail ['list'][$key]['place_id']  = $this->sql(".assoc.foreign", "place", $value["place_id"], "name");
			}	
		}
		return $classes_detail;
	}

	public function tag($tag = false) {
		return new tagMaker_lib($tag);
	}
}
?>