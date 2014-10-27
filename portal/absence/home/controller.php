<?php
/**
* @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
*/
class controller extends main_controller{
	
	function config(){
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
		), function() {
			save(array("absence", "option"));
			$this->permission = array("absence" => array("insert" => array("public", "private")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("absence", "option"));
			$this->permission = array("absence" => array("update" => array("public", "private")));
		});
	}
}
?>