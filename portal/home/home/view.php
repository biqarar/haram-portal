<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'Profile';

		//------------------------------ globals type
		$this->global->type = isset($_SESSION['users_type']) ? $_SESSION['users_type'] : "";		

		//------------------------------ globals (name & family)
		$this->global->name = isset($_SESSION['users_name']) ? $_SESSION['users_name'] : "";
		
		$this->global->family = isset($_SESSION['users_family']) ? $_SESSION['users_family'] : "";
		
		//------------------------------ globals (gender)
		if(isset($_SESSION['users_gender'])){
		
			$this->global->gender = ($_SESSION['users_gender']  == "male") ? _("Mr.") : _("Mrs.");
		
		}
	}
}
?>