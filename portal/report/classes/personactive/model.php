<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_classesactive($start_date = false, $end_date = false) {

	$classes = $this->sql()->tableClasses()->whereStatus("running")->orStatus("ready")->field("id");
	$classes->joinPlan()->whereId("#classes.plan_id")->fieldId("classification_id");
	$classes->groupOpen();
	//---------- get branch id in the list
	foreach ($this->branch() as $key => $value) {
		if($key == 0){
			$classes->condition("and", "plan.branch_id","=",$value);
		}else{
			$classes->condition("or","plan.branch_id","=",$value);
		}
	}
	$classes->groupClose();

	$classes->joinClassification()->whereClasses_id("#classes.id")->fieldId()
		->groupOpen()
		->condition("and", "#date_delete" , "is", "#null")
		->condition("or", "#because", "is", "#null")
		->groupClose();

	$classes->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->field("value");
	$classes= $classes->select();
	echo($classes->string());exit();

	return $classes->allAssoc();
	}
}
?>