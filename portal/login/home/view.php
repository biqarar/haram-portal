<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'login';

		//------------------------------ load form
		$f = $this->form("@users");

		//------------------------------ set hidden value to get $_POST in model
		$f->hidden->value("login");
		
		//------------------------------ load captcha from
		if(isset($_SESSION['load_captcha']) && $_SESSION['load_captcha']) {
			$captcha = $this->form("captcha");
			$f->add("captcha", $captcha);
			$f->atEnd("submit");
		}

		//------------------------------ change caption of sumbit
		$f->submit->value("login");

		//------------------------------ remove email field (in phase 2 can be login whit email)
		$f->remove("email");
	}
}
?>