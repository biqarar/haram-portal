<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_weekly($startdate = false, $enddate = false) {
	$price = $this->sql()->tablePrice()
			->condition("where", "#date" , ">", $startdate)
			->condition("and", "#date", "<", $enddate)
			->condition("and", "#pay_type", "like", "pos%")
			->fieldDate()
			->fieldPay_type()
			->fieldValue()
			->fieldCard();

	$price->joinPerson()->whereUsers_id("#price.users_id")->fieldName()->fieldFamily();
	$price = $price->select()->allAssoc();
			return $price;

		// var_dump($startdate, $enddate); exit();
		
	}
	public function post_report(){
	
	}	
}
?>