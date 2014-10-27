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
			save(array("position", "option"));
			$this->permission = array("position" => array("insert" => array("public")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("position", "option"));
			$this->permission = array("position" => array("update" => array("public")));
		});
	}
}
?>