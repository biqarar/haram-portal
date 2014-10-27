<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class model extends main_model{
	public function makeQuery() {
		return $this->sql()->tableBridge()
			->setUsers_id(post::users_id())
			->setTitle(post::title())
			->setValue(post::value())
			->setDescription(post::description());
	}

	public function post_add_bridge() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert bridge successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert bridge failed]]");
		});
	}

	public function post_edit_bridge() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update bridge successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update bridge failed]]");
		});
	}
}
?>