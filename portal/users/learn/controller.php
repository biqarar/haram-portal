<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{
	
	function config(){

		$this->listen(array(
			"max" => 1,
			"url" => array("id" => "/^\d+$/")
			), function() {
			save(array("users", "learn"));
			$this->permission = array("person" => array("select" => array("public")));
		});
		
		$this->listen(array(
			"max" => 2,
			"url" => array("classes", "id" => "/^\d+$/")
			), function() {
			save(array("users", "learn", "classes"));
			$this->permission = array("person" => array("select" => array("public")));
		});

		$this->listen(array(
			"max" => 2,
			"url" => array("absence", "id" => "/^\d+$/")
			), function() {
			save(array("users", "learn", "absence"));
			$this->permission = array("person" => array("select" => array("public")));
		});

		$this->listen(array(
			"max" => 3,
			"url" => array("absence", "classes", "id" => "/^\d+$/")
			), function() {
			save(array("users", "learn", "absence" , "classes"));
			$this->permission = array("person" => array("select" => array("public")));
		});



	}
}
?>