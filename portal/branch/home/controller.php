<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class controller extends main_controller{
	// public $permission = array("branch" => array("insert" => array("public", "private"),
	// 					"update" => array("public", "private")),
	// 			"branch_description" => array("insert" => array("public"), "update" => array("public"))
	// );
	function config(){	
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
			), function () {
			save(array("branch", "option"));
			$this->permission = array("branch" => array("insert" => array("public")));
		});
		$this->listen(array(
			"max" => 2,
			"url" => array("edit","/^\d+$/")
			), function () {
			save(array("branch", "option"));
			$this->permission = array("branch" => array("update" => array("public")));
		});
		$this->listen(array(
			"max" => 3,
			"url" => array("description", "/^(add|edit)$/")
			), function() {
			save(array("branch", "description"));
			$this->permission = array("branch_description" => array("insert" => array("public"), "update" => array("public")));
		});
	}

}
?>