<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		$f = $this->sql(".formQuestions", $this->xuId("formid"));
		// $f = $this->form("@branch");
		// var_dump($f);
		$this->data->q = $f;
		// var_dump($this->data->q);
		// exit();
	}
}
?>