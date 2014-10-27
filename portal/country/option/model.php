<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableCountry()
				->setName(post::name());
	}

	public function post_add_country(){
		$sql = $this->makeQuery()->insert();

		$this->commit(function() {
			debug_lib::true("[[insert country successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert country failed]]");
		});
	}

	public function post_edit_country(){
		$sql = $this->makeQuery()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update country ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update country failed]]");
		});
	}
}
?>