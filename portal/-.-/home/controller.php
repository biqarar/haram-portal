<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller {
	public $permission = array();
	public function config() {
		$this->listen(array(
			"max" => 0,
			"url" => ""
			),
		function () {
			save(array("profile"));
			if(isset($_SESSION['users_id'])){
				$this->access = true;
			}
		}
		);
		$this->listen(array(
			"max" => 0,
			"url" => "profile"
			)
		);
	}
}
?>