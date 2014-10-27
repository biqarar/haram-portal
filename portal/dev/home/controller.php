<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $access = true;
	function config(){
		$this->listen(array(
			"max" =>2,
			"url"=>array("add")
			), function(){
			save(array("dev","option"));
			$this->permission = array("dev" => array("insert"));
		});
		$this->listen(array(
			"max" => 2,
			"url" => array("edit", "/^\d+$/")
			), array("dev", "option"));
		$this->listen(array(
			"max" => 2,
			"url" => ""
			), array("dev", "home"));
	}
}
?>