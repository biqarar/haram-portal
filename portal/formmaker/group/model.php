<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model {

	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()->tableForm_group()->setName(post::name())->setDescription(post::description());
	}

	public function post_add_form_group() {
		//------------------------------ insert form_group
		$sql = $this->makeQuery()->insert();
		// print_r($sql->string());
			
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert form_group successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert form_group failed]]");
		});
	}

	public function post_edit_form_group() {
		//------------------------------ update form_group
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		// print_r($sql->string());


		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update form_group successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update form_group failed]]");
		});
	}
}
?>