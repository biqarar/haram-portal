<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableEducation()
				->setGroup(post::group())
				->setSection(post::section());
	}

	public function post_add_education() {
		$sql = $this->makeQuery()
				->insert();
		$this->commit(function() {
			debug_lib::true("[[insert education ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert education failed]]");
		});
	}

	public function post_edit_education() {
		$sql = $this->makeQuery()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update education ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update education failed]]");
		});
	}
}
?>