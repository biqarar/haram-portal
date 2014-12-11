<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model {

	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()->tableForm_group_item()
		->setForm_group_id(post::form_group_id())
		->setForm_questions_id(post::form_questions_id());
	}

	public function post_add_form_group_item() {
		//------------------------------ insert form_group_item
		$sql = $this->makeQuery()->insert();
		// print_r($sql->string());
			
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert form_group_item successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert form_group_item failed]]");
		});
	}

	public function post_edit_form_group_item() {
		//------------------------------ update form_group_item
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		// print_r($sql->string());


		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update form_group_item successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update form_group_item failed]]");
		});
	}
}
?>