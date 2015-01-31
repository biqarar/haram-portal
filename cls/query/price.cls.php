<?php 
class query_price_cls extends query_cls {

	public function checkClasses($users_id = false, $classes_id = false, $dateNow = false) {

		$plan_id = $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assoc("plan_id");
		$price = $this->sql()->tablePlan()->whereId($plan_id)->limit(1)->select()->assoc("price");
		if($price == null) return true;
		$user_active_price = $this->sum_price($users_id);
		
		if(intval($user_active_price) >= intval($price) || global_cls::superprice()){
			$this->price_low($users_id, $classes_id, $price, $dateNow);
			
			return true;
		}else{
			return false;
		}
	}

	public function price_low($users_id = false, $classes_id = false, $price = false, $dateNow = false) {

		$x = $this->sql()->tablePrice()
			->setUsers_id($users_id)
			->setDate($dateNow)
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