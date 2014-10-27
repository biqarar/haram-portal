<?php
class controller extends main_controller{
	function config(){
		if(config_lib::$url == "captcha.png"){
			new captcha_lib;
			exit();
		}

		$this->listen(array(
			"max" => 1,
			"url" => array("logout")
			), function() {
			session_destroy();
			header("location: ".host."/login");
		});
	}
}
?>