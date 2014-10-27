<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'Profile';
		$this->global->name = isset($_SESSION['users_name']) ? $_SESSION['users_name'] : "";
		$this->global->family = isset($_SESSION['users_family']) ? $_SESSION['users_family'] : "";
		if(isset($_SESSION['gender'])){
			$this->global->gender = ($_SESSION['gender']  == "male") ? _("Mr.") : _("Mrs.");
		}
		// var_dump($_SESSION);
	}
}
?>