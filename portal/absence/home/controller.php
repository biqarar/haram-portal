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
			$this->access = true;
		});

		$this->listen(array(
		"max" =>3,
		"url" => array("status" => "classeslist", "classesid" => "/^\d+$/")
		),
		function(){
			save(array("absence", "classeslist", 'mod' => "classeslist"));
			$this->access = true;
		});
		
	}
}
?>