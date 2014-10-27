<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $permission = array("group" => array("insert" => array("public"),
						"update" => array("public")),
				"group_expert" => array("insert" => array("public"),
						"update" => array("public"))
	);
	function config(){
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
		), function() {
			save(array("group", "option"));
			$this->permission = array("group" => array("insert" => array("public", "private")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("group", "option"));
			$this->permission = array("group" => array("update" => array("public")));
		});
		
		$this->listen(array(
			"max" => 3,
			"url" => array("expert", "/^(add|edit)$/")
			), function () {
			save(array("group", "expert"));
			$this->permission = array("group_expert" => array("insert" => array("public"), "update" => array("public")));
		});
		$this->listen(array(
			"max" => 3,
			"url" => array("list", "/^(add|edit)$/")
			), function () {
			save(array("group", "list"));
			$this->permission = array("group_list" => array("insert" => array("public"), "update" => array("public")));
		});
	}
}
?>