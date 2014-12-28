<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tablePrice()
				->setUsers_id(post::users_id())
				->setDate(post::date())
				->setType(post::type())				
				->setValue(post::value())
				->setPay_type(post::pay_type())
				->setTransactions(post::transactions())
				->setDescription(post::description());
	}

	public function post_add_price(){
		$sql = $this->makeQuery()->insert();
		ilog($sql->string());
		$this->commit(function() {
			debug_lib::true("[[insert price successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert price failed]]");
		});
	}

	public function post_edit_price(){
		$sql = $this->makeQuery()
				->whereId($this->xuId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update price ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update price failed]]");
		});
	}
}
?>