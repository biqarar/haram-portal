<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tablePosition()->setPosition(post::position());
	}
	public function post_add_position() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert position successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert position failed]]");
		});
	}

	public function post_edit_position() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update position successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update position failed]]");
		});
	}

}
?>