<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_day_bridge($day = "sat") {

	$classes = $this->sql()->tableClasses()->condition("where","`classes`.`week_days`","like","'%$day%'")
			->groupOpen()
				->andStatus("running")
				->orStatus("ready")
			->groupClose();
		// $classes->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue("mobile");
			// $classes->joinBridge()

	$classes = $classes->select()->allAssoc();
	// var_dump($classes);exit();

	$classification = $this->sql()->tableClassification();
		
		$classification->groupOpen();
		foreach ($classes as $key => $value) {
			$classification->orClasses_id($value['id']);
		}
		$classification->groupClose()->fieldId();
		
		$this->classification_finde_active_list($classification);
		
		$classification->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue("mobile");
		$classification->joinClasses()->whereId("#classification.classes_id")
		->fieldName()->fieldStart_time()->fieldEnd_time();
		$classification->joinPlan()->whereId("#classes.plan_id")->fieldName("planname");

		$x = $classification->groupValue()->select();
	return $x->allAssoc();
	
	}
}
?>