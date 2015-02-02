<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function sql_classes_list($classes_id = false) {
		$q =  $this->sql()->tableClassification()->whereClasses_id($classes_id)->groupOpen()
				->condition("and", "#date_delete" , "is", "#null")
				->condition("or", "#because", "is", "#null")
				->groupClose();
		$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName()->fieldFamily();
		// $q->joinBridge()->whereUsers_id("#classification.users_id")->fieldValue();
		$q->joinUsers()->whereId("#classification.users_id")->fieldUsername();
		$x = $q->fieldUsers_id()->select()->allAssoc();
		return $x;
	}

	public function sql_classes_detail($classes_id = false) {
		return $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assco();
	}

	public function sql_score_type($plan_id = false) {
		return $this->sql()->tableScore_type()->wherePlan_id($plan_id)->select()->allAssoc();
	}
}
?>