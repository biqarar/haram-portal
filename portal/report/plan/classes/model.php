<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_classes($start_date = false, $end_date = false) {
	

	$classes = $this->sql()->tableClasses()
			->condition("where", "#start_date" , "<=", $this->sql(".duplicateUsersClasses.convert_date",$end_date))
			->condition("and", "#end_date", ">=", $this->sql(".duplicateUsersClasses.convert_date",$start_date));
	$classes->joinPlan()->whereId("#classes.plan_id")->fieldName('planname')->fieldMax_person("maxp");

	$classes = $classes->select()->allAssoc();
		
		$return = array();
	foreach ($classes as $key => $value) {
		// var_dump($value);exit();
		$return[$value['plan_id']]['name'] = $value['planname'];

		isset($return[$value['plan_id']]['classes_count']) ? 
			  $return[$value['plan_id']]['classes_count']++ :
			  $return[$value['plan_id']]['classes_count'] = 1;

		isset($return[$value['plan_id']]['classification_count']) ? 
			  $return[$value['plan_id']]['classification_count'] += intval($value['count']) :
			  $return[$value['plan_id']]['classification_count'] = intval($value['count']);

		$return[$value['plan_id']]['max_person'] = $value['maxp'];
		$return[$value['plan_id']]['average'] = intval($return[$value['plan_id']]['classification_count']) /  intval( $return[$value['plan_id']]['classes_count']);

	}
	
			return $return;

		// var_dump($startdate, $enddate); exit();
		
	}
	public function post_classes(){
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : false;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : false;
		
		var_dump($this->sql_classes($start_date, $end_date));
		// var_dump("ffff");exit();
	}	
}
?>