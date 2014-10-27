<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tableGroup_list()
			->setName(post::name())
			->setDescription(post::description())
			->setExpert(post::expert())
			->setStatus(post::status());
	}
	public function post_add_group_list() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert group_list successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert group_list failed]]");
		});
	}

	public function post_edit_group_list() {
		$sql = $this->makeQuery()->whereId($this->uId(3))->update();
		$this->commit(function() {
			debug_lib::true("[[update group_list successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update group_list failed]]");
		});
	}

}
?>