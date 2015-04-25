<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function post_changepasswd() {

		$msg = "error";

		//------------------------------ if old password is true
		if(isset($_SESSION['users_id'])){
			$user = $this->sql()
				->tableUsers()
				->whereId($_SESSION['users_id'])
				->andPassword(md5(post::oldpasswd()))
				->limit(1)
				->select();
				
			if($user->num() == 1){
				//------------------------------ if password == repassword 
				if(post::newpasswd() == post::repasswd()){
					$changepasswd = $this->sql()
						->tableUsers()
						->setPassword(md5(post::newpasswd()))
						->whereId($_SESSION['users_id'])
						->update();
				}else{
					//------------------------------ make fatal error (password != repasswrod)
					debug_lib::fatal("[[new password not match whit repssword]]");
				}
				
			}else{
				//------------------------------ make falal error (old password is incurect)
				debug_lib::fatal("[[old password is incorect]]");
			}	
		}else{
			// $this->redirect("login");
		}

		//------------------------------ commit code
		$this->commit(function(){
			debug_lib::true("[[password changed]]");
		});

		//------------------------------ rollback code
		$this->rollback(function($msg){
			debug_lib::fatal($msg);
		}, $msg);
		
	}
}
?>