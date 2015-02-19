<?php 
class query_scoreCalculation_cls extends query_cls {

	/**
	*	list of score saved 
	* 	score type title
	*	username, name, family
	*/
	public function list_score($classesid = false , $type = "classes") {

		// if($type == "users") {
		// 	$calculation = $this->sql()->tableClasses()->whereId($classesid)->fieldId();
		// }else{
		// 	$classification->classification->claaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
		// }

		$calculation = $this->sql()->tableClasses()->whereId($classesid)->fieldId();
		$calculation->joinPlan()->whereId("#classes.plan_id")->fieldId();
		$calculation->joinScore_calculation()->wherePlan_id("#classes.plan_id")->andStatus("active");
		$calculation->joinClassification()->whereClasses_id("#classes.id")
		               	->groupOpen()
						->condition("and", "#date_delete" , "is", "#null")
						->condition("or", "#because", "is", "#null")
						->groupClose()
		               	 ->fieldId();
		$calculation->joinScore()->whereClassification_id("#classification.id")->fieldValue();
		$calculation->joinScore_type()->whereId("#score.score_type_id")->fieldTitle();
		$calculation->joinPerson()->whereUsers_id("classification.users_id")->fieldName()->fieldFamily();
		$calculation->joinUsers()->whereId("#classification.users_id")->fieldUsername("username")->fieldId("users_id");
		$calculation = $calculation->select()->allAssoc();
		
		return $calculation;
	}


	public function _eval($arg = false) {
		$run = false;
		$list = array();
		foreach ($arg as $key => $value) {
			if(is_array($value)) {
				$run = true;
				foreach ($value as $k => $v) {
					if($k == 'value' 
					|| $k == 'title'
					|| $k == 'name'
					|| $k == 'family'
					|| $k == 'username' ){
						$list[$value['users_id']][$k][] = $v;
					}
				}	
			}
		}
		if($run) {
			$calculation = $arg[0]['calculation'];
			foreach ($list as $key => $value) {
				$x = $calculation;
				
				foreach ($value['title'] as $k => $v) {
					$x = preg_replace("/\=". $v ."\=/", $value['value'][$k], $x);
				}				
				$list[$key]['result'] = (@eval("return " . $x . ";" ) ? @eval("return " . $x . ";" ) : "-");
			}
			return $list;
		}
	}
		 
	public function score_classes($classesid = false , $type = "classes") {
		return $this->_eval($this->list_score($classesid, $type));
	}
}
?>