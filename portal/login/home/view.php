<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'login';
		$f = $this->form("@users");
		$f->hidden->value("login");
		
		if(isset($_SESSION['load_captcha']) && $_SESSION['load_captcha']) {
			$captcha = $this->form("captcha");
			$f->add("captcha", $captcha);
			$f->atEnd("submit");
		}
		$f->submit->value("login");
		$f->remove("email");
	}
}
?>