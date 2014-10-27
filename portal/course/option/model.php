<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableCourse()
				->setBegin_time(post::begin_time())
				->setEnd_time(post::end_time())
				->setExpert(post::expert())
				->setBranch_id(post::branch_id())
				->setName(post::name());
	}

	public function post_add_course(){
		$sql = $this->makeQuery()->insert();

		$this->commit(function() {
			debug_lib::true("[[insert course successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert course failed]]");
		});
	}

	public function post_edit_course(){
		$sql = $this->makeQuery()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update course ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update course failed]]");
		});
	}
}
?>