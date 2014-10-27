<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{
	public function makeQuery() {
		return $this->sql()->tableGroup()->setName(post::name());
	}
	
	public function post_add_group() {
		$sql = $this->makeQuery()->insert();
		
		$this->commit(function() {
			debug_lib::true("[[insert group successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert group failed]]");
		});
	}

	public function post_edit_group() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update group successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update group failed]]");
		});
	}
}
?>