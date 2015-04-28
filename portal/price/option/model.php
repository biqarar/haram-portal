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
				// ->setUsers_id($this->xuId("usersid"))
				->setDate(post::date())			
				->setValue($value)
				->setPay_type(post::pay_type())
				->setCard(post::card())
				->setTitle(post::title())
				->setTransactions(post::transactions())
				->setDescription(post::description());
	}

	public function post_add_price(){
		$sql = $this->makeQuery();
		
		$sql->setUsers_id($this->xuId("usersid"));

		if(!$this->check_price()){
			debug_lib::fatal("اطلاعات وارد شده با مقادیر حساب تناقض دارد");
		}else{
			if(post::type() == 'plan' && post::plan_id() == '') {
				debug_lib::fatal("در حالت رزرو شهریه برای طرح حتما باید نام طرح ثبت شود.");
			}elseif(post::type() == "common" && post::plan_id() != ""){
				$sql->setDescription(post::description());
			}elseif(post::type() == 'plan' && post::plan_id() != '') {
				$sql->setDescription($this->plan_name(post::plan_id()) . " - " . post::description());
			}
			$sql = $sql->insert();
		}
	
		$this->commit(function() {
			debug_lib::true("[[insert price successful]]");
		});
		
		$this->rollback(function() {
			debug_lib::fatal("[[insert price failed]]");
		});
	}

	public function plan_name($plan_id = false) {
		return $this->sql()->tablePlan()->whereId($plan_id)->limit(1)->fieldName()->select()->assoc("name");
	}

	public function post_edit_price(){
		$sql = $this->makeQuery();

		if(!$this->check_price()){
			debug_lib::fatal("اطلاعات وارد شده با مقادیر حساب تناقض دارد");
		}else{
			if(post::type() == 'plan' && post::plan_id() == '') {
				debug_lib::fatal("در حالت رزرو شهریه برای طرح حتما باید نام طرح ثبت شود.");
			}elseif(post::type() == "common" && post::plan_id() != ""){
				$sql->setDescription(post::description());
			}elseif(post::type() == 'plan' && post::plan_id() != '') {
				$sql->setDescription($this->plan_name(post::plan_id()) . " - " . post::description());
			}
			$sql->whereId($this->xuId())->update();
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