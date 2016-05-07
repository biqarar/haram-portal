<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tablePending_classes()
			->setUsers_id($this->login()? $_SESSION['user']['id'] : 223)
			->setClasses_id(post::classes_id())
			->setDate("13930616")
			->setDescription(post::desc());
	}
	public function post_add_pending_classes() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert pending_classes successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert pending_classes failed]]");
		});
	}

	public function post_edit_pending_classes() {
		$sql = $this->makeQuery()->whereId($this->uId(3))->update();
		$this->commit(function() {
			debug_lib::true("[[update pending_classes successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update pending_classes failed]]");
		});
	}

}
?>