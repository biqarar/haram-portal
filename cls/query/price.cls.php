<?php 
class query_price_cls extends query_cls {

	
	public function checkClasses($users_id = false, $classes_id = false) {
		// var_dump("users_id = " . $users_id, "classes = " . $classes_id);
		$plan = $this->sql()->tableClasses()->whereId($classes_id)->fieldPlan_id();
		$plan->joinPlan()->whereId("#classes.plan_id")->fieldPrice("planPrice");
		$plan = $plan->limit(1)->select()->assoc();
		$plan_id = $plan['plan_id'];

		if($plan['planPrice'] == "") return true;

		$price = $this->sql()->tableUserprice()->whereUsers_id($users_id)->andStatus("fullpayment")
				->andPlan_id($plan_id)->limit(1)->select();

		if($price->num() == 1) {
			$price = $price->assoc();
			
				$this->sql()->tableUserprice()
					->whereId($price['id'])
					->setClasses_id($classes_id)
					->setStatus("invalid")
					->update();
					return true;

		}else{
		
			$price = $this->sql()->tableUserprice()
				->whereUsers_id($users_id)
				->andStatus("fullpayment")
				->andPlan_id("is", "#null")
				->limit(1)
				->select();

			if($price->num() == 1){
				$price = $price->assoc();
				if($price["value"] >= $plan['planPrice']){
				$this->sql()->tableUserprice()->whereId($price['id'])
					->setPlan_id($plan['plan_id'])
					->setClasses_id($classes_id)
					->setStatus("invalid")
					->update();
				return true;
				}
			
			}else{
				if(global_cls::superprice()){
					$v =	$this->sql()->tableUserprice()
						->setUsers_id($users_id)
						->setPlan_id($plan['plan_id'])
						->setClasses_id($classes_id)
						->setStatus("debtor")
						->setDate($this->dateNow())
						->setTitle(5)
						->setCard("00")
						->setTransactions("00")
						->setPay_type("rule")
						->setValue($plan['planPrice'])
						->insert()->LAST_INSERT_ID();
				}
				return false;
			}
		}
	}

	// public function price_type($users_id = false, $plan_id = false){
	// 	$type = $this->sql()->tablePrice()
	// 		->whereUsers_id($users_id)
	// 		->andStatus("active")
	// 		->fieldType("typePrice")
	// 		->fieldValue("value")
	// 		->fieldPlan_id("planid");
	// 	$type->joinPrice_change()->whereId("#price.title")->fieldType("type");
	// 	$type = $type->select()->allAssoc();
	// 	var_dump($type);
	// 	$this->sum_price_($type, $plan_id);
	// }

	// public function sum_price_($array = false, $plan_id = false) {
		
	// 	$sum_active = 0;
	// 	$sum_common = 0;
	// 	$sum_plan   = 0;
	// 	$sum_low    = 0;
	// 	$sum_all    = 0;
	// 	$count      = 0;

	// 	foreach ($array as $key => $value) {

	// 		if($value['type'] == "price_add"){
				
	// 			if($value['typePrice'] == 'common'){
	// 				$sum_common = $sum_common + intval($value['value']);
	// 			}elseif($value['typePrice'] == 'plan' && $value['planid'] == $plan_id){
	// 				$sum_plan = $sum_plan + intval($value['value']);
	// 			}
				
	// 			$sum_active = $sum_active + intval($value['value']);
	// 			$sum_all = $sum_all + intval($value['value']);
			
	// 		}elseif($value['type'] == "price_low"){

	// 			if($value['typePrice'] == 'common'){
	// 				$sum_common -= intval($value['value']);
	// 			}elseif($value['typePrice'] == 'plan'){
	// 				$sum_plan = $sum_plan -  intval($value['value']);
	// 			}
				
	// 			$sum_active = $sum_active - intval($value['value']);
	// 			$sum_low = $sum_low + intval($value['value']);
	// 		}

	// 		$count++;

	// 	}

	// 	var_dump(
	// 		'sum_active=  ' . $sum_active, 'sum_common=  ' . $sum_common, 'sum_plan=  ' . $sum_plan,
	// 		'sum_low=  ' . $sum_low, 'sum_all=  ' . $sum_all, 'count=  ' . $count);
		
	// }
	// public function price_type_check($classes_id = false, $users_id = false) {
	// 	$plan_id = $this->sql()->tableClasses()->whereId($classes_id)
	// 		->limit(1)->fieldPlan_id()->select()->assoc("plan_id");

	// 	$price = $this->sql()->tablePrice()->whereUsers_id($users_id)->andStatus("active");
	// 	$price->joinPrice_change()->whereId("#price.title")->fieldType("priceChangeType");
	// 	$price = $price->select()->allAssoc();
	// 	var_dump($price);
	// }

	// public function price_low($users_id = false, $classes_id = false, $price = false) {
	// 	$x = $this->sql()->tablePrice()
	// 		->setUsers_id($users_id)
	// 		->setDate($this->dateNow("Ymd"))
	// 		->setValue($price)
	// 		->setPay_type("rule")
	// 		->setTitle(5)
	// 		->setTransactions($classes_id)
	// 		->insert();
	// }

	// public function sum_price($users_id) {
		
	// 	$price = $this->sql()->tablePrice()->whereUsers_id($users_id);
	// 	$price->joinPrice_change()->whereId("#price.title");
	// 	$price = $price->select()->allAssoc();
		
	// 	$sum_active = 0;
	// 	$sum_low = 0;
	// 	$sum_all = 0;
	// 	$count = 0;
	// 	foreach ($price as $key => $value) {
	// 		if($value['type'] == "price_add"){
	// 			$sum_active = $sum_active + intval($value['value']);
	// 			$sum_all = $sum_all + intval($value['value']);
	// 		}elseif($value['type'] == "price_low"){
	// 			$sum_active = $sum_active - intval($value['value']);
	// 			$sum_low = $sum_low + intval($value['value']);
	// 		}
	// 		$count++;
	// 	}
	// 	$ret = array();
	// 	$ret['sum_all'] = $sum_all;
	// 	$ret['sum_low'] = $sum_low;
	// 	$ret['sum_active'] = $sum_active;
	// 	$ret['count_transaction'] = $count;
		
	// 	return $ret;
	// }
}
?>