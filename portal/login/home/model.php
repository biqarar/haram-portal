<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_login() {
		if(!$this->sql(".loginCounter.login") && (!isset($_SESSION['CAPTCHA_GNA']) || $_SESSION['CAPTCHA_GNA'] != post::captcha())){
			// load_captcha
			// die(var_dump(1));
			$_SESSION['load_captcha'] = true;
			debug_lib::fatal("captcha incorrect");
			$this->redirect("login");
		}else{
			$u = $this->sql()->tableUsers()
			->whereUsername(post::username())
			->andPassword(md5(post::password()))->limit(1)->select();

			if($u->num() == 1) {				
				$this->sql(".loginCounter.clear");
				$this->sql(".setLoginSession" , $u);
				if(isset($_SESSION['redirect'])){
					$redirect = $_SESSION['redirect'];
					unset($_SESSION['redirect']);
					$this->redirect($redirect);
				}else{
					$this->redirect("/profile");
					header("Location: /profile");
				}

			}else{
				if(isset($_SESSION['CAPTCHA_GNA'])){
					unset($_SESSION['CAPTCHA_GNA']);
					debug_lib::msg("captcha", true);
				}
				$this->redirect("login");
				debug_lib::fatal("username or password incorrect");
			}
		}
	}
}
?>