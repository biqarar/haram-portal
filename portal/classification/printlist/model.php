<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function sql_classes_list($classes_id = false) {
		$q =  $this->sql()->tableClassification()->whereClasses_id($classes_id);

		$q = $this->classification_finde_active_list($q);
		$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName()->fieldFamily()->orderFamily();
		// $q->joinBridge()->whereUsers_id("#classification.users_id")->fieldValue();
		$q->joinUsers()->whereId("#classification.users_id")->fieldUsername();
		$x = $q->fieldUsers_id()->select()->allAssoc();
		foreach ($x as $key => $value) {
			$x[$key]['price'] = $this->find_sum_price($value['users_id']);
		}
		return $x;
	}

	public function find_sum_price($users_id = false) {
		$price_list = $this->sql(".price.sum_price" , $users_id);
		if(intval($price_list['sum_active'])  < 0 ) {
			$return = "نیازمند پرداخت شهریه" . $price_list['sum_active'];
		}else{
			$return = "";
			// $return = $price_list['sum_active'];
		}
		return $return;
	}

	public function sql_classes_detail($classes_id = false) {
		return $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assco();
	}

	public function sql_score_type($plan_id = false) {
		return $this->sql()->tableScore_type()->wherePlan_id($plan_id)->select()->allAssoc();
	}


}
?>