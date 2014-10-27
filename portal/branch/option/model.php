<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		return $this->sql()->tableBranch()->setName(post::name())->setGender(post::gender());
	}
	public function post_add_branch() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert branch successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert branch failed]]");
		});
	}

	public function post_edit_branch() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update branch successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update branch failed]]");
		});
	}

}
?>