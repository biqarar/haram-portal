<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{
	
	function config(){
		//------------------------------ users/description
		$this->listen(array(
			"max"=> 3,
			'url' => array("description", "/^(|add|edit)$/")),
		function () {
			save(array("users", "description"));
			$this->permission = array("users_description" => array("insert" => array("public", "private"),
									"update" => array("public")));
			}
		);

		//------------------------------ users status=learn/type=classes
		$this->listen(array(
			"max"=> 3,
			'url' => array("status" => "learn" , "type" => "classes" ,"id" => "/^\d+$/")),
		function () {
			save(array("users", "learn", "classes"));
			$this->permission = array("users" => array("select" => array("public", "private")));
			}
		);

		//------------------------------ users status=learn
		$this->listen(array(
			"max"=> 3,
			'url' => array("status" => "learn" , "id" => "/^\d+$/")),
		function () {
			save(array("users", "learn"));
			$this->permission = array("users" => array("select" => array("public", "private")));
			}
		);


		//------------------------------ users/group
		$this->listen(array(
			"max"=> 3,
			'url' => array("group", "/^(|add|edit)$/")),
		function () {
			save(array("users", "group"));
			$this->permission = array("users_group" => array("insert" => array("public") , "update" => array("public")));
		});

		//------------------------------ users/branch
		$this->listen(array(
			"max"=> 3,
			'url' => array("branch", "/^(|add|edit)$/")),
		function () {
			save(array("users", "branch"));
			$this->permission = array("users_branch" => array("insert" => array("public") , "update" => array("public")));
		});

	}
}
?>