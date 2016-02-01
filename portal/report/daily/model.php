<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_day($day = false) {
	

	$classes = $this->sql()->tableClasses()->condition("where","`classes`.`week_days`","like","'%$day%'")
			->groupOpen()
				->andStatus("running")
				->orStatus("ready")
			->groupClose();
			// var_dump($classes->select()->string());exit();
	$classes->joinPlan()->whereId("#classes.plan_id")->fieldName('planname')->fieldMax_person("maxp");

	$classes = $classes->select()->allAssoc();
	return $classes;
	
	}
}
?>