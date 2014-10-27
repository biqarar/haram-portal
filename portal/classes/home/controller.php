<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{
	// public $permission = array("classes" => array("insert" => array("public", "private"),
	// 					"update" => array("public", "private")));
	function config(){
		// $this->listen(array(
		// 	"max" => 1,
		// 	"url" => ""
		// 	), 
		// function () {
		// 	save(array("classes", "home"));
		// 	$this->permission = array("classification" => array("insert" => array("public")));
		// }
		// 	);
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
			), 
		function () {
			save(array("classes", "option"));
			$this->permission = array("classes" => array("insert" => array("public")));
		}
			);
		$this->listen(array(
			"max" => 2,
			"url" => array("edit", "/^\d+$/")
			), 
		function () {
			save(array("classes", "option"));
			$this->permission = array("classes" => array("update" => array("public")));
		}
			);
		$this->listen(array(
			"max" => 2,
			"url" => array("pending", "/^(|add|edit)$/")
			), function () {
			save(array("classes", "pending"));
		$this->permission = array("pending_classes" => array("insert" => array("public"), "update" => array("public")));
		} );
		$this->listen(array(
			"max" => 2,
			"url" => array("detail", "/^\d+$/")
			),
		function () {
			save(array("classes", "detail"));
			$this->permission = array("classification" => array("insert" => array("public")),
						"classes" => array("select" => array("public", "private"))
				);
		} 
		);
	}
}
?>