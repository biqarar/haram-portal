<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function post_changepasswd() {
		$msg = "";
		if(isset($_SESSION['users_id'])){
			$user = $this->sql()
				->tableUsers()
				->whereId($_SESSION['users_id'])
				->andPassword(md5(post::oldpasswd()))
				->limit(1)
				->select();
				
			if($user->num() == 1){
				if(post::newpasswd() == post::repasswd()){
					$changepasswd = $this->sql()
						->tableUsers()
						->setPassword(md5(post::newpasswd()))
						->whereId($_SESSION['users_id'])
						->update();
						// var_dump($changepasswd);
						// exit();	
						// debug_lib::true("[[password changed]]");
				}else{
					// $msg = '[[new password not match whit repssword]]';
					debug_lib::fatal("[[new password not match whit repssword]]");
				}
				
			}else{
				// $msg = '[[old password is incorect]]';
				debug_lib::fatal("[[old password is incorect]]");
			}	
		}else{
			// $this->redirect("login");
		}
		$this->commit(function(){
			debug_lib::true("[[password changed]]");
		});
		$this->rollback(function($msg){
			debug_lib::fatal($msg);
		}, $msg);
		
	}
}
?>