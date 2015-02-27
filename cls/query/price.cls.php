<?php 
class query_price_cls extends query_cls {

	public function checkClasses($users_id = false, $classes_id = false) {
		var_dump("users_id = " . $users_id, "classes = " . $classes_id);
		$plan_id = $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assoc("plan_id");
		var_dump("plan_id = " . $plan_id);
		$this->price_type($users_id, $plan_id);

		var_dump("fuck");exit();		
		$price = $this->sql()->tablePlan()->whereId($plan_id)->limit(1)->select()->assoc("price");
		// if($price == null) return true;
		$user_active_price = $this->sum_price($users_id);
		
		$this->price_type_check($classes_id, $users_id);
		if(intval($user_active_price) >= intval($price) || global_cls::superprice()){
			$this->price_low($users_id, $classes_id, $price);
			// return true;
		}else{
			// return false;
		}
	}

	public function price_type($users_id = false, $plan_id = false){
		$type = $this->sql()->tablePrice()
			->whereUsers_id($users_id)
			->andPlan_id($plan_id)
			->andStatus("active")
			->fieldType("typePrice")
			->fieldValue("value");
		$type->joinPrice_change()->whereId("#price.title")->fieldType("type");
		$type = $type->select()->allAssoc();
		var_dump($type);
		$this->sum_price_($type);
	}

	public function sum_price_($array = false) {
		$sum_active = array();
		$sum_low = array();
		$sum_all = 0;
		$count = 0;
		// $sum_active[$arry['typePrice']] = 0;
		foreach ($array as $key => $value) {
			if($value['type'] == "price_add"){
				$sum_active[$value['typePrice']] = $sum_active[$value['typePrice']] + intval($value['value']);
				$sum_all = $sum_all + intval($value['value']);
			}elseif($value['type'] == "price_low"){
				$sum_active[$value['typePrice']] = $sum_active[$value['typePrice']] - intval($value['value']);
				$sum_low = $sum_low + intval($value['value']);
			}
			$count++;
		}
		var_dump($sum_all, $sum_active);
		
	}
	public function price_type_check($classes_id = false, $users_id = false) {
		$plan_id = $this->sql()->tableClasses()->whereId($classes_id)
			->limit(1)->fieldPlan_id()->select()->assoc("plan_id");

		$price = $this->sql()->tablePrice()->whereUsers_id($users_id)->andStatus("active");
		$price->joinPrice_change()->whereId("#price.title")->fieldType("priceChangeType");
		$price = $price->select()->allAssoc();
		var_dump($price);
	}

	public function price_low($users_id = false, $classes_id = false, $price = false) {
		$x = $this->sql()->tablePrice()
			->setUsers_id($users_id)
			->setDate($this->dateNow("Ymd"))
			->setValue($price)
			->setPay_type("rule")
			->setTitle(5)
			->setTransactions($classes_id)
			->insert();
	}

	public function sum_price($users_id) {
		
		$price = $this->sql()->tablePrice()->whereUsers_id($users_id);
		$price->joinPrice_change()->whereId("#price.title");
		$price = $price->select()->allAssoc();
		
		$sum_active = 0;
		$sum_low = 0;
		$sum_all = 0;
		$count = 0;
		foreach ($price as $key => $value) {
			if($value['type'] == "price_add"){
				$sum_active = $sum_active + intval($value['value']);
				$sum_all = $sum_all + intval($value['value']);
			}elseif($value['type'] == "price_low"){
				$sum_active = $sum_active - intval($value['value']);
				$sum_low = $sum_low + intval($value['value']);
			}
			$count++;
		}
		$ret = array();
		$ret['sum_all'] = $sum_all;
		$ret['sum_low'] = $sum_low;
		$ret['sum_active'] = $sum_active;
		$ret['count_transaction'] = $count;
		
		return $ret['sum_active'];
	}
}
?>