<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class controller extends main_controller{
	public $permission = array("price" => array("insert" => array("public"),
						"update" => array("public")));
	function config(){
		$this->listen(array(
			"max" => 2,
			"url" => array("add", "/^\d+$/")
			), array("price", "option"));
		$this->listen(array(
			"max" => 2,
			"url" => array("edit", "/^\d+$/")
			), array("price", "option"));
	}
}
?>