<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'Profile';

		//------------------------------ globals type
		$this->global->type = isset($_SESSION['user']['type']) ? $_SESSION['user']['type'] : "";		

		//------------------------------ globals (name & family)
		$this->global->name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : "";
		
		$this->global->family = isset($_SESSION['user']['family']) ? $_SESSION['user']['family'] : "";
		
		//------------------------------ globals (gender)
		if(isset($_SESSION['user']['gender'])){
		
			$this->global->gender = ($_SESSION['user']['gender']  == "male") ? _("Mr.") : _("Mrs.");
		
		}
	}
}
?>