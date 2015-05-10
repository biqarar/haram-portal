<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		//------------------------------ make sql object to insert and update fields
		return $this->sql()->tableCourseclasses()
				->setCourse_id(post::course_id())
				->setClasses_id(post::classes_id());
	}

	public function post_add_courseclasses() {

		//------------------------------ insert courseclasses
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert courseclasses successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert courseclasses failed]]");
		});
	}

	public function post_edit_courseclasses() {

		//------------------------------ update courseclasses
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update courseclasses successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update courseclasses failed]]");
		});
	}
}
?>