<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */

class controller extends main_controller {
	public $permission = array();
	public function config() {		
		if(config_lib::$url == "captcha.png"){
			new captcha_lib;
			exit();
		}

		$this->listen(array(
			"max" => 1,
			"url" => array("logout")
			), function() {
			$_SESSION = array();
			session_destroy();
			header("location: ".host."/login");
			exit();
		});

		$this->listen(array(
			"max" => 1,
			"url" => "/^(|profile|changepasswd)$/"
			),
		function () {
			if(isset($_SESSION) && isset($_SESSION['users_id'])){
				$this->access = true;
			}
		}
		);

		$this->listen(array(
			"max" => 2,
			"url" => "changepasswd"
			), array("home","passwd"));

		$this->listen(array(
			"max" => 2,
			"url" => "settings"
			), 
		function() {
			save(array("home","settings"));
			$this->access = true;
		});

	}
}
?>