<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{
		// public $access = true;
	function config(){
		
		$this->listen(array(
			"max" => 2,
			"url" => array("api", "/^(.*)$/")
			),
			function() {
				save(array("class" => "person", "method"=> "api", "mod" => "list"));
				$this->permission  =array("classification" => array("select" => array("public", "private")));
			} );

		// $this->listen(array(
		// 	"max" => 2,
		// 	"url" => array("add")
		// 	), function () {
		// 	save(array("person", "option"));
		// 	$this->permission = array("person" => array("insert" => array("public")));
		// });

		// $this->listen(array(
		// 	"max" => 2,
		// 	"url" => array("edit", "/^\d+$/")),
		// function() {
		// 	save(array("person", "option"));
		// 	$this->permission = array("person" =>array("update" => array("public")));
		// 	// if(isset($_SESSION['users_id']) && $_SESSION['users_id'] == config_lib::$aurl[2]){
		// 	// 	$this->access = true;	
		// 	// }
		// }
		// );	
	}	
	
}
?>