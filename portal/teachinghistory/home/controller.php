<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $permission = array("teachinghistory" => array("insert" => array("public"),
						"update" => array("public")));
	function config(){
		$this->listen(array(
			"max" => 1,
			"url"=>array("add")
			), array("teachinghistory","option"));
		$this->listen(array(
			"max" => 2,
			"url"=>array("edit", "/^\d+$/")
			), array("teachinghistory","option"));
	}
}
?>