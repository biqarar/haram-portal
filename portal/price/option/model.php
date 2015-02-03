<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function sql_find_usersid($score_id = false) {
		return $this->sql()->tablePrice()->whereId($score_id)->limit(1)->fieldUsers_id()->select()->assoc("users_id");
	}

	public function makeQuery() {
		$value = preg_replace("/\,/", "", post::value());
		return $this->sql()->tablePrice()
				->setUsers_id($this->xuId("usersid"))
				->setDate(post::date())			
				->setValue($value)
				->setPay_type(post::pay_type())
				->setCard(post::card())
				->setTitle(post::title())
				->setTransactions(post::transactions())
				->setDescription(post::description());
	}

	public function post_add_price(){

		if(!$this->check_price()){
			debug_lib::fatal("اطلاعات وارد شده با مقادیر حساب تناقض دارد");
		}else{
			$sql = $this->makeQuery()->insert();
			// print_r($sql->string());
		}

		
		$this->commit(function() {
			debug_lib::true("[[insert price successful]]");
		});
		
		$this->rollback(function() {
			debug_lib::fatal("[[insert price failed]]");
		});
	}

	public function post_edit_price(){
		if(!$this->check_price()){
			debug_lib::fatal("اطلاعات وارد شده با مقادیر حساب تناقض دارد");
		}else{
			$sql = $this->makeQuery()->whereId($this->xuId())->update();
		}

		
		$this->commit(function() {
			debug_lib::true("[[update price successful]]");
		});
		
		$this->rollback(function() {
			debug_lib::fatal("[[update price failed]]");
		});

	}

	public function check_price() {
		$usersid  = $this->xuId("usersid");
		$value    = post::value();
		$title = post::title();

		$type = $this->sql()->tablePrice_change()->whereId($title)->limit(1)->select()->assoc("type");
		if($type == "price_low") {
			$sum = $this->sql(".price.sum_price", $usersid);
			if(intval($sum) < intval($value)){
				return false;
			}
		}
		return true;
	}
}
?>