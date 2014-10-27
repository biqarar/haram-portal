<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class model extends main_model{
	
	public function makeQuery() {
		return $this->sql()->tablePlace()
				->setName(post::name())
				->setBranch_id(post::branch_id())
				->setDescription(post::description());
	}

	public function post_add_place() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert place successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert place failed]]");
		});

	}

	public function post_edit_place() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update place successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update place failed]]");
		});
	}
}
?>