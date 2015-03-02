<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/

class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableDev()
			->setDate(post::date())
			->setDescription(post::description())
			->setAdress(post::adress())
			->setReport(post::report())
			->setRepair(post::repair())
			->setStatus(post::status());
	}

	public function post_add_dev(){
		$sql = $this->makeQuery()->insert();

		$this->commit(function() {
			debug_lib::true("[[insert dev successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert dev failed]]");
		});
	}

	public function post_edit_dev(){
		$sql = $this->makeQuery()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update dev successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update dev failed]]");
		});
	}
}
?>