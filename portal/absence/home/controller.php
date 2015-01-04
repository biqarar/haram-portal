<?php
/**
* @author Reza Mohiti <rm.biqarar@gmail.com>
*/
class controller extends main_controller{
	public function config() {
	$this->listen(array(
		"max" => 2,
		"url" => array("classes", "classesid" => "/^\d+$/")
		),
		function(){
			save(array("absence", "classes"));
			$this->permission = array("absence" => array("insert" => array("public")));
		});

		$this->listen(array(
		"max" =>3,
		"url" => array("status" => "classeslist", "classesid" => "/^\d+$/")
		),
		function(){
			save(array("absence", "classeslist", 'mod' => "classeslist"));
			$this->permission = array("absence" => array("insert" => array("public")));
		});

		$this->listen(array(
		"max" =>4,
		"url" => array( "api", "classification" =>"/^\d+$/",  "date" => "/^\d{8}$/")
		),
		function(){
			save(array("absence", "api", 'mod' => "api"));
			$this->permission = array("absence" => array("insert" => array("public")));
		});


		$this->listen(array(
		"max" =>3,
		"url" => array("status" =>"add",  "usersid" => "/^\d+$/")
		),
		function(){
			save(array("absence", "option"));
			$this->permission = array("absence" => array("insert" => array("public")));
		});
		
	}
}
?>