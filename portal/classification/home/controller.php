<?php
class controller extends main_controller{
	
	function config(){
		$this->listen(array(
			"max" => 3,
			"url" => array("add", "/^\d+$/", "/^\d+$/")
			), function () {
			save(array("classification", "api", "classification"));
			$this->permission = array("classification" => array("insert" => array("public")));
		});
		
		$this->listen(array(
			"max" => 2,
			"url" => array("edit", "/^\d+$/")
			), function () {
			save(array("classification", "option"));
			$this->permission = array("classification" => array("update" => array("public")));
 		});

		$this->listen(array(
			"max" => 1,
			"url" => "/^\d+$/"
			), function () {
			save(array("classification", "classes"));
			$this->permission = array("classification" => array("insert" => array("public")));
		});
		$this->listen(array(
			"max" => 4,
			"url" => array("api", "/^\d+$/", "/^\d+$/")

		), function () {
			save(array("class" => "classification", "method"=> "api", "mod" => "insert"));
			$this->permission = array("classification" => array("select" => array("public", "private")));
			// $this->access = true;
		}
		);
			// ), array("class" => "classification", "method"=> "api", "mod" => "insert"));
			// ), array("classification", "api", "insert"));
	}
}
?>