<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function makeQuery() {
		return $this->sql()->tableClassification()
				->setUsers_id(post::users_id())
				->setDate_entry(post::date_entry())
				->setDate_delete(post::date_delete())
				->setBecause(post::because())
				->setMark(post::mark())
				->setPlan_section_id(post::plan_section_id())
				->setClasses_id(post::classes_id());
	}

	public function post_add_classification() {
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert classification successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert classification failed]]");
		});
	}

	public function post_edit_classification() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update classification successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update classification failed]]");
		});
	}
}
?>