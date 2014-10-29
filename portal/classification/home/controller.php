<?php
class controller extends main_controller{
	
	function config(){
		$this->listen(array(
			"max" => 3,
			"url" => array("classes", "/^\d+$/", "/^\d+$/")
			), function () {
			save(array("classification", "api", "classification"));
			$this->permission = array("classification" => array("insert" => array("public")));
		});
		
		//------------------------------ load form to insert users to a classes
		$this->listen(array(
			"max" => 2,
			"url" => array("classesid"=> "/^\d+$/")
			), 
			function () {
				save(array("classification", "classes"));
				$this->permission = array("classification" => array("insert" => array("public")));
			}
		);
		
		//------------------------------ api to insert users to classes
		$this->listen(array(
			"max" => 4,
			"url" => array("api", "usersid" => "/^\d+$/", "classesid" => "/^\d+$/")
		), 
		function () {
			save(array("class" => "classification", "method"=> "api", "mod" => "insert"));
				$this->permission = array("classification" => array("select" => array("public", "private")));
			}
		);
	}
}
?>