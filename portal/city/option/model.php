<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{
	public function makeQuery() {
		return $this->sql()->tableCity()->setName(post::name())->setProvince_id(post::province());
	}

	public function post_add_city() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert city successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert city failed]]");
		});
	}

	public function post_edit_city() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update city successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update city failed]]");
		});
	}
}
?>