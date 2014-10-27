<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class controller extends main_controller{
	
	function config(){

		$this->listen(array(
			"max" => 1,
			'url' => "list"),
		function () {
			save(array("users", "list"));
			$this->permission = array("users" => array("select" => array("public")));
		});
		
		$this->listen(array(
			"max" => 2,
			'url' => array("detail" , "/^\d+$/")),
		function () {
			save(array("users", "detail"));
			$this->permission = array("users" => array("select" => array("public")));
		});

		$this->listen(array(
			"max" => 2,
			'url' => "/^(add)$/"),
			function(){
				// save(array("login"));
				// if(isset($_SESSION['users_id']) && is_int($_SESSION['users_id'])){
					// $this->redirect("profile");
				// }else{
					save(array("users", "option"));
					$this->permission = array("users" => array("insert" => array("public")));
					// $this->access = true;	
				// }
			}
		);

		// $this->listen(array(
		// 	"max" => 2,
		// 	'url' => array("edit", "/^\d+$/")),
		// function() {
		// 	save(array("person", "option"));
		// 	if(isset($_SESSION['users_id']) && $_SESSION['users_id'] == config_lib::$aurl[2]){
		// 		$this->access = true;	
		// 	}	
		// }
		// );
		
		$this->listen(array(
			"max"=> 3,
			'url' => array("description", "/^(|add|edit)$/")),
		function () {
			save(array("users", "description"));
			$this->permission = array("users_description" => array("insert" => array("public", "private"),
									"update" => array("public")));
		}
		);

		$this->listen(array(
			"max"=> 3,
			'url' => array("group", "/^(|add|edit)$/")),
		function () {
			save(array("users", "group"));
			$this->permission = array("users_group" => array("insert" => array("public") , "update" => array("public")));
		});

		$this->listen(array(
			"max"=> 3,
			'url' => array("branch", "/^(|add|edit)$/")),
		function () {
			save(array("users", "branch"));
			$this->permission = array("users_branch" => array("insert" => array("public") , "update" => array("public")));
		});

		$this->listen(array(
			"max"=> 1,
			'url' => array("changepasswd")),
		array("users", "passwd"));
	}
}
?>