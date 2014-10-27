<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableProvince()->
				setName(post::name());
	}
	public function post_add_province() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert province successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert province failed]]");
		});
	}

	public function post_edit_province() {
		$sql = $this->sql()->tableProvince()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update province successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update province failed]]");
		});
	}
}
?>