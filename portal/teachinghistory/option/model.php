<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class model extends main_model{
	
	public function makeQuery() {
		return $this->sql()->tableTeachinghistory()
				->setUsers_id(post::users_id())
				->setField(post::field())
				->setClub(post::club())
				->setLength(post::length());
	}

	public function post_add_teachinghistory() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert teachinghistory successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert teachinghistory failed]]");
		});
	}

	public function post_edit_teachinghistory() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update teachinghistory successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update teachinghistory failed]]");
		});
	}
}
?>