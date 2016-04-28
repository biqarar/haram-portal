<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_classesactive($start_date = false, $end_date = false) {

	$classes = $this->sql()->tableClasses()->whereStatus("running")->orStatus("ready")->field("id");
	$classes->joinClassification()->whereClasses_id("#classes.id")->fieldId()
		->groupOpen()
		->condition("and", "#date_delete" , "is", "#null")
		->condition("or", "#because", "is", "#null")
		->groupClose();

	$classes->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->field("value");
	$classes= $classes->select();
	// var_dump($classes->mmu());exit();

	return $classes->allAssoc();
	}
}
?>