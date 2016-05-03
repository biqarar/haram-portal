<?php
class query_login_cls extends query_cls {
	
	/**
	* @param sql object whit select users id
	*/

	public $users_id = false;

	public function config($users_id = false) {
		
		$this->users_id = $users_id;
		var_dump("ffff");

// var_dump($this->check());exit();
		
		return $this->check();

	}

	public function check() {

		$_SESSION['user']['branch'] = array();
		$_SESSION['user']['branch_active'] = array();
		
		foreach ($this->users_branch() as $index => $value) {
			//------------------------------ set branch_id  session (all branch for this user)
			$_SESSION['user']['branch'][] = $value;
			$_SESSION['user']['branch_active'][] = $value['branch_id'];
		}
		// var_dump($users_branch);exit();
		if(
			count($this->users_branch()) > 1 &&
			(!isset($_SESSION['select_branch']) || $_SESSION['select_branch'] == null)) {
			// var_dump("fuck");exit();
			// var_dump(expression)
			$this->redirect("fuk");
			// header("location:".host."/selectbranch");
			return false;
			// exit();
		}else{
			$this->set_session();
			return true;
		}
	}

	public function users_branch() {
		$users_branch = $this->sql()
							 ->tableUsers_branch()
							 ->whereUsers_id($this->users_id)
							 ->select()
							 ->allAssoc();
		
		return $users_branch;

	}


	public function set_session( ){

		$users_data = $this->sql()->tableUsers()->whereId($this->users_id)->limit(1)->select()->assoc();

		
		//------------------------------ set status session
		$_SESSION['user']['status'] = $users_data['status'];

		//------------------------------ set email session
		$_SESSION['user']['email'] = $users_data['email'];
		

		$sql_person = $this->sql()->tablePerson()->whereUsers_id($this->users_id)->limit(1)->select()->assoc();
		
		//------------------------------ set name session
		$_SESSION['user']['name']   = $sql_person['name'];

		//------------------------------ set family session
		$_SESSION['user']['family'] = $sql_person['family'];
		
		//------------------------------ set gender session
		$_SESSION['user']['gender'] = $sql_person['gender'];


		//------------------------------ set users_id session
		$_SESSION['user']['id']     = $this->users_id;
		
		$this->permission();

	}

	public function permission() {
		return ;
		//------------- check type if users.type == student or == teacher 
		// not NULL
		// else 
		// set permission

		//------------------------------ set list of permission session
		$session = array();
		$permission = $this->sql()->tablePermission();
		$permission->joinUsers_branch()->whereId("#permission.users_branch_id")->andUsers_id($this->users_id);
		$permission = $permission->select();
		var_dump($permission->string());exit();
		// ->select()->allAssoc();

		foreach ($permission as $key => $value) {
			if($value['select'] != NULL ) $session['tables'][$value["tables"]]['select'] = $value['select'];
			if($value['update'] != NULL ) $session['tables'][$value["tables"]]['update'] = $value['update'];
			if($value['insert'] != NULL ) $session['tables'][$value["tables"]]['insert'] = $value['insert'];
			if($value['delete'] != NULL ) $session['tables'][$value["tables"]]['delete'] = $value['delete'];
			if($value['condition'] != NULL ) $session['tables'][$value["tables"]]['condition'] = $value['condition'];
		}
		$_SESSION['user']['permission'] = $session;
		
	}
}
?>