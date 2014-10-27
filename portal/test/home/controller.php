<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class controller extends main_controller{
	public $access = true;
	function config(){
		$this->listen(array(
			"max" => 2,
			"url" => array("api")
			), array("class" => "test", "method"=> "api", "mod" => "list"));
		$this->listen(array(
			"max" => 3,
			"url" => array("add")
			), array("test", "option"));
		$this->listen(array(
			"max" => 2,
			"url" => array("edit", "/^\d+$/")
			), array("test", "option"));
	}
}
?>