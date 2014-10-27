<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class controller extends main_controller {
	public $access = true;
	public function config() {
		$this->listen(array(
			"max" => 1,
			"url" => ""
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