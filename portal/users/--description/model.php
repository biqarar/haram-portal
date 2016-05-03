
<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tableUsers_description()
			->setUsers_id(post::users_id())
			->setText(post::text());
	}
	public function post_add_users_description() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert users_description successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert users_description failed]]");
		});
	}

	public function post_edit_users_description() {
		$sql = $this->makeQuery()->whereId($this->uId(3))->update();
		$this->commit(function() {
			debug_lib::true("[[update users_description successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update users_description failed]]");
		});
	}

}
?>