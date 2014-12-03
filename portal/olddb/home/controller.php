<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */

class controller extends main_controller {

	public function config() {		
	
		$this->listen(array(
			"max" => 2,
			"url" => array("student1", "id" => "/^\d+$/")
			),
			function (){
				save(array("olddb","student1"));
				$this->permission = array("student1" => array("select" => array("public", "private")));	
			});

		$this->listen(array(
			"max" => 2,
			"url" => array("price", "id" => "/^\d+$/")
			),
			function (){
				save(array("olddb","price"));
				$this->permission = array("oldprice" => array("select" => array("public", "private")));	
			});

		$this->listen(array(
			"max" => 2,
			"url" => array("classes", "id" => "/^\d+$/")
			),
			function (){
				save(array("olddb","classes"));
				$this->permission = array("oldclasses" => array("select" => array("public", "private")));	
			});
		$this->listen(array(
			"max" => 2,
			"url" => array("classification", "id" => "/^\d+$/")
			),
			function (){
				save(array("olddb","classification"));
				$this->access = true;
				$this->permission = array("oldclassification" => array("select" => array("public", "private")));	
			});

	}
}
?>