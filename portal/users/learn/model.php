<?php 
/**
* 
*/
class model extends main_model {

	public function sql_find_list_certification($usersid = false) {
		$certification = $this->sql()->tableClassification()
			->whereUsers_id($usersid)
			->condition("and", "certification.classification_id", "IS", "NULL")
			->fieldId()->fieldMark();
		$certification->joinClasses()->whereId("#classification.classes_id")->fieldId("classesid");
		$certification->joinPlan()->whereId("#classes.plan_id")
			->condition("and", "##classification.mark", ">=" , "#plan.mark")
			->fieldName("planname")->fieldId("planid");
		$certification->joinCertification("LEFT OUTER")
			->whereClassification_id("=" , "#classification.id");

		$ready = $certification->select()->allAssoc();
		
		// return $ready;

		$duplicate = $this->sql()->tableCertification();
		$duplicate->joinClassification()->whereId("#certification.classification_id");
		$duplicate->joinClasses()->whereId("#classification.classes_id");
		$q = $duplicate->joinPlan()->whereId("#classes.plan_id");
		foreach ($ready as $key => $value) {
			$q->andId("=", $value['planid']);
		}
		
		$duplicate = $duplicate->select()->num();

		return ($duplicate == 0) ? $ready : array();
		
	}

	public function sql_absence_list($usersid = false, $classes_id = false) {
		$list = $this->sql()->tableAbsence();
		$list->joinClassification()->whereId("#absence.classification_id")
					->andUsers_id($usersid)->andClasses_id($classes_id)->fieldUsers_id()->fieldClasses_id();
		// $list->joinClasses()->whereId("#classification.classes_id")
			// ->fieldTeacher()->fieldPlan_id()->fieldPlace()->fieldStart_time();
		$list = $list->select()->num();
		return $list;
	}

	public function sql_price_list($users_id = false) {
		$price = $this->sql()->tableUserprice()->whereUsers_id($users_id);
		$price->joinPrice_change()->whereId("#userprice.title");
		$price = $price->select()->allAssoc();
		$sum_low = 0;
		$sum_all = 0;
		$sum_active = 0;
		$count = 0;
		foreach ($price as $key => $value) {
			if($value['status'] == "fullpayment"){
				$sum_active = $sum_active + intval($value['value']);
			}else{
				$sum_low = $sum_low + intval($value['value']);
			}
			$sum_all = $sum_all + intval($value['value']);
			$count++;
		}
		$ret = array();
		$ret['sum_all'] = $sum_all;
		$ret['sum_low'] = $sum_low;
		$ret['sum_active'] = $sum_active;
		$ret['count_transaction'] = $count;
		return $ret;

		// $sum_active = 0;
		// $sum_low = 0;
		// $sum_all = 0;
		// $count = 0;
		// foreach ($price as $key => $value) {
		// 	if($value['type'] == "price_add"){
		// 		$sum_active = $sum_active + intval($value['value']);
		// 		$sum_all = $sum_all + intval($value['value']);
		// 	}elseif($value['type'] == "price_low"){
		// 		$sum_active = $sum_active - intval($value['value']);
		// 		$sum_low = $sum_low + intval($value['value']);
		// 	}
		// 	$count++;
		// }
		// $ret = array();
		// $ret['sum_all'] = $sum_all;
		// $ret['sum_low'] = $sum_low;
		// $ret['sum_active'] = $sum_active;
		// $ret['count_transaction'] = $count;
		// return $ret;
	}

	public function sql_classification_list($usersid = false) {
		$return = array();
		$return['sum_active'] = 0;
		$return['sum_all'] = 0;
		$return['classes'] = array();
		$sql = $this->sql()->tableClassification()->whereUsers_id($usersid);
		$sql->joinClasses()->whereId("#classification.classes_id");
		$sql->joinPlan()->whereId("#classes.plan_id")->fieldName("planname");
		$sql->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
		$sql->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teachername")->fieldFamily("teacherfamily");
		$x = $sql->select()->allAssoc();
		foreach ($x as $key => $value) {

			$return['sum_all']++;
			if(empty($x[$key]['date_delete']) || $x[$key]['date_delete'] == ''){
				$return['sum_active']++;

				$return['classes'][$key]['string'] = $x[$key]['planname'] 		. '  ' .
								   _($x[$key]["age_range"]) 		. '  ' . 
								   $x[$key]['placename'] 		. ' ساعت ' .
								   $x[$key]['end_time']			. ' استاد ' .
								   $x[$key]["teachername"] 		. '  ' . 
								   $x[$key]['teacherfamily'];
				$return['classes'][$key]['id'] = $x[$key]["classes_id"];
				}
								   
		}
		return $return;

	}
}
?>