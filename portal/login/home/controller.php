<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller {
	public $access = true;
	public function config() {
		$this->listen(array(
			"max" => 1,
			"url" => array("")
			), 
		function() {
			save(array("login"));
			if(isset($_SESSION['users_id'])){
				$this->redirect("profile");
			}
			
		});
	}
}
?>