<?php
/**
 * @author reza mohtit <rm.biqarar@gmail.com>
 */
class controller extends main_controller{
	function config(){
		$this->listen(array(
			"max" => 1,
			"url"=>array("add")), 
			array("folders","option"));
		$this->listen(array(
			"max" => 2,
			"url"=>array("edit", "/^\d+$/")), 
			array("folders","option"));
	}
}
?>