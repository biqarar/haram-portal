<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tableUsers_group()
			->setUsers_id(post::users_id())
			->setGroup_list_id(post::group_list_id());
	}
	public function post_add_users_group() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert users_group successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert users_group failed]]");
		});
	}

	public function post_edit_users_group() {
		$sql = $this->makeQuery()->whereId($this->uId(3))->update();
		$this->commit(function() {
			debug_lib::true("[[update users_group successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update users_group failed]]");
		});
	}

}
?>