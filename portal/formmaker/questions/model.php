<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model {

	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()->tableForm_questions()
		->setString(post::string())
		->setAnswer_type(post::answer_type())
		->setAnswer_value(post::answer_value())
		->setAnswer_validate(post::answer_validate())
		->setAllow_null(post::allow_null())
		->setMultiple_answer(post::multiple_answer());
	}

	public function post_add_form_questions() {
		//------------------------------ insert form_questions
		$sql = $this->makeQuery()->insert();
		// print_r($sql->string());
			
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert form_questions successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert form_questions failed]]");
		});
	}

	public function post_edit_form_questions() {
		//------------------------------ update form_questions
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		// print_r($sql->string());


		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update form_questions successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update form_questions failed]]");
		});
	}
}
?>