<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_login() {
		//------------------------------ set login countey for load captcha
		if(!$this->sql(".loginCounter.login") && (!isset($_SESSION['CAPTCHA_GNA']) || $_SESSION['CAPTCHA_GNA'] != post::captcha())){
			
			$_SESSION['load_captcha'] = true;
			debug_lib::fatal("اعداد درون تصویر را به صورت صحیح وارد کنید");
			$this->redirect("login");
		
		}else{
			
			$u = $this->sql()->tableUsers();
				if(preg_match("/@/", post::username())) {
					$u = $u->whereEmail(post::username());
				} else {
					$u = $u->whereUsername(post::username());
				}

			$u = $u->andPassword(md5(post::password()))->limit(1)->select();

			//------------------------------ username and password tru
			if($u->num() == 1) {				

				//------------------------------ clear history of try to login
				$this->sql(".loginCounter.clear");

				//------------------------------ set login session (permission, menu , ...)
				$this->sql(".setLoginSession" , $u);

				//------------------------------ redirect to page (profile || save page)
				if(isset($_SESSION['redirect'])){
					$redirect = $_SESSION['redirect'];
					unset($_SESSION['redirect']);
					$this->redirect($redirect);
				}else{
					$this->redirect("/profile");
				}

			}else{
				
				if(isset($_SESSION['CAPTCHA_GNA'])){
					unset($_SESSION['CAPTCHA_GNA']);
					debug_lib::msg("captcha", true);
				}
				$this->redirect("login");
				debug_lib::fatal("نام کاربری و یا کلمه عبور اشتباه است");
			}
		}
	}
}
?>