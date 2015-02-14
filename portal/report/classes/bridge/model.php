<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_bridge_list($classesid = false) {
		$classes_id = preg_split("/\,/", $classesid);
		if(!$classesid || empty($classes_id)) return false;
		
		$classification = $this->sql()->tableClassification();
		
		$classification->groupOpen();
		foreach ($classes_id as $key => $value) {
			$classification->orClasses_id($value);
		}
		$classification->groupClose()->fieldId();
		
		$classification->groupOpen()
			->condition("and", "#date_delete" , "is", "#null")
			->condition("or", "#because", "is", "#null")
		->groupClose();
		
		$classification->joinUsers()->whereId("#classification.users_id")->fieldUsername();

		$classification->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("name")->fieldFamily("family");

		$classification->joinClasses()->whereId("#classification.classes_id")
			->fieldStart_time()
			->fieldEnd_time()
			->fieldStart_date()
			->fieldEnd_date()
			->fieldWeek_days();

		$classification->joinPlan()->whereId("#classes.plan_id")->fieldName("plan");
		
		$classification->joinPlace()->whereId("#classes.place_id")->fieldName("place");
		
		$classification->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue("mobile");

		$x = $classification->groupValue()->select();
		$x = $x->allAssoc();

		return $x;
	}
	public function post_report(){
	
	}	
}
?>