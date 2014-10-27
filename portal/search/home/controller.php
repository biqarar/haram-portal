<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $access = true;
	function config(){
		$this->listen(array(
			"max" =>3,
			"url"=> "/^(.*)$/"
			), function(){
			save(array("search","tables"));
			// $this->permission = array("search" => array("insert"));
		});

	}
}
?>