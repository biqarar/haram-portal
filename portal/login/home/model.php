<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_login() {
		//------------------------------ set login countey for load captcha
		// if(!$this->sql(".loginCounter.login") && (!isset($_SESSION['CAPTCHA_GNA']) || $_SESSION['CAPTCHA_GNA'] != post::captcha()) || true){
		// // var_dump("fuck");exit();
			
		// 	$_SESSION['load_captcha'] = true;
		// 	debug_lib::fatal("اعداد درون تصویر را به صورت صحیح وارد کنید");
		// 				var_dump(1);

		// 	$this->redirect("login");
		
		// }else{
			var_dump(2);
			
			$u = $this->sql()->tableUsers();
				if(preg_match("/@/", post::username())) {
					$u = $u->whereEmail(post::username());
				} else {
					$u = $u->whereUsername(post::username());
				}

			$u = $u->andPassword(md5(post::password()))->limit(1)->select();

			//------------------------------ username and password tru
			if($u->num() == 1) {				
				var_dump(3);
				//------------------------------ clear history of try to login
				$this->sql(".loginCounter.clear");
				var_dump($this->sql(".login" , $u->assoc("id")));exit();
				//------------------------------ set login session (permission, menu , ...)
				if($this->sql(".login" , $u->assoc("id"))) {
					//------------------------------ redirect to page (profile || save page)
					var_dump(5);
					if(isset($_SESSION['redirect'])){
						$redirect = $_SESSION['redirect'];
						unset($_SESSION['redirect']);
						$this->redirect($redirect);
					}else{
						var_dump(4);exit();
						$this->redirect("/profile");
					}
				
				}

			// }else{
				
			// 	if(isset($_SESSION['CAPTCHA_GNA'])){
			// 		unset($_SESSION['CAPTCHA_GNA']);
			// 		debug_lib::msg("captcha", true);
			// 	}
			// 			var_dump(5);exit();

			// 	$this->redirect("login");
			// 	debug_lib::fatal("نام کاربری و یا کلمه عبور اشتباه است");
			// }
		}
	}
}
?>