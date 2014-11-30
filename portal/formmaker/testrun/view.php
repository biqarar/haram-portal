<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		$form_questions = $this->sql(".formQuestions", $this->xuId("formid"));
		// $f = $this->form("@branch");
		// var_dump($f);
		exit();
	}
}
?>