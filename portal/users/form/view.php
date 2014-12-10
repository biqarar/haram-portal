<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view {

	public function config(){
		$this->global->url = "formmaker/testrun/usersid=1/formid=1";
		$this->data->extendForm = true;
		$f = $this->sql(".formQuestions", $this->xuId("formid"), $this->urlStatus());
		$this->data->q = $f;
		var_dump($this->sql(".formQuestions.xlist", $this->xuId("formid"), $this->xuId("usersid")));		
	}
}
?>