<?php
class controller extends main_controller{
	
	function config(){
		//------------------------------ load form to search in person
		$this->listen(array(
			"max" => 3,
			"url" => "/^(search)\/(classesid\=\d+)$/"
			), 
			function () {
				save(array("classification", "search"));
				$this->permission = array("classification" => array("insert" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 3,
			"url" => array("classes", "/^\d+$/", "/^\d+$/")
			), function () {
			save(array("classification", "api", "classification"));
			$this->permission = array("classification" => array("insert" => array("public")));
		});
		
		//------------------------------ classification list
		$this->listen(array(
			"max" => 2,
			"url" => array("printlist", "classesid" => "/^\d+$/")
			), 
			function () {
				save(array("classification", "printlist"));
				$this->access = true;
				// $this->permission = array("classification" => array("insert" => array("public")));
			}
		);

		//------------------------------ load form to insert users to a classes
		$this->listen(array(
			"max" => 2,
			"url" => array("class","classesid"=> "/^\d+$/")
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


		//------------------------------ load form to insert absence for all person in classes
		$this->listen(array(
			"max" => 3,
			"url" => array("absence","classesid"=> "/^\d+$/")
			), 
			function () {
				save(array("classification", "absence"));
				$this->permission = array("absence" => array("insert" => array("public")));
			}
		);

		//------------------------------ load form to insert absence for  one person in classes
		//------------------------------ go to absence option
		$this->listen(array(
			"max" => 3,
			"url" => array("absence","classificationid"=> "/^\d+$/")
			), 
			function () {
				save(array("absence", "option"));
				$this->permission = array("absence" => array("insert" => array("public")));
			}
		);
	}
}
?>