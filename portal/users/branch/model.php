<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tableUsers_branch()
			->setUsers_id(post::users_id())
			->setBranch_id(post::branch_id());
	}
	public function post_add_users_branch() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert users_branch successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert users_branch failed]]");
		});
	}

	public function post_edit_users_branch() {
		$sql = $this->makeQuery()->whereId($this->uId(3))->update();
		$this->commit(function() {
			debug_lib::true("[[update users_branch successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update users_branch failed]]");
		});
	}

}
?>