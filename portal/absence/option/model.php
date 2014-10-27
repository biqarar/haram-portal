<?php
/**
* @author reza mohiti
*/
class model extends main_model {

	public function makeQuery() {
		 return $this->sql()->tableAbsence()
				->setClassification_id(post::classification_id())
				->setDate(post::date())
				->setBecause(post::because())
				->setType(post::type());
	}

	public function post_add_absence(){
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert absence successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert absence failed]]");
		});
	}

	public function post_edit_absence() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update absence successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update absence failed]]");
		});
	}
}
 ?>