<?php 
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller
{
	function config(){

		//***************************************
		header("location:".host."/portal/login");
		exit();
		//***************************************

		$this->listen(array(
			"max" => 2,
			"url" => array("posts", "more")
			),
		array("class" => "posts", "method" =>"more")
		);
		$this->listen(array(
			"max" => 1,
			"url" => "/.{1,}/"
			),
		array("home", "posts")
		);
		$this->listen(array(
			"max" => 2,
			"url" => array("contact")
			),
		array("class" => "contact", "method"=> "home")
		);
		$this->listen(array(
			"max" => 2,
			"url" => array("strategy")
			),
		array("class" => "strategy", "method"=> "home")
		);
		$this->listen(array(
			"max" => 2,
			"url" => array("register")
			),
	array("class" => "register", "method"=> "homeREZA")
		);
	}
}
?>