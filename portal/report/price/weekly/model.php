<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_weekly($startdate = false, $enddate = false) {
	$price = $this->sql()->tablePrice()
			->condition("where", "#date" , ">=", $startdate)
			->condition("and", "#date", "<=", $enddate)
			->condition("and", "#pay_type", "like", "pos%")
			->fieldDate()
			->fieldPay_type()
			->fieldValue()
			->fieldCard();

	$price->joinPerson()->whereUsers_id("#price.users_id")->fieldName()->fieldFamily();

	$price->joinUsers_branch()->whereUsers_id("#person.users_id");
	$price->groupOpen();
	//---------- get branch id in the list
	foreach ($this->branch() as $key => $value) {
		if($key == 0){
			$price->condition("and", "users_branch.branch_id","=",$value);
		}else{
			$price->condition("or","users_branch.branch_id","=",$value);
		}
	}
	$price->groupClose();

	$price = $price->select()->allAssoc();
	// var_dump($price);exit();
			return $price;


		// var_dump($startdate, $enddate); exit();
		
	}
	public function post_report(){
	
	}	
}
?>