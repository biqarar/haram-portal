<?php
class query_login_cls extends query_cls {
	
	/**
	* @param sql object whit select users id
	*/

	public $users_id = false;

	public function config($users_id = false) {
		
		$this->users_id = $users_id;
		//------------------------------ set users_id session
		$_SESSION['user']['id']     = $this->users_id;

		return $this->check();

	}

	public function check() {

		// $_SESSION['user']['branch'] = array();
		// $_SESSION['user']['branch']['all'] = array();
		// $_SESSION['user']['branch']['active'] = array();
		
		$users_branch =	$this->users_branch();
		// var_dump($users_branch);exit();

		foreach ($users_branch as $index => $value) {
			//------------------------------ set branch_id  session (all branch for this user)
			$_SESSION['user']['branch']['all'][$index] = $value;

			if($value['status'] == "enable") {

				$_SESSION['user']['branch']['active'][$index] = $value['branch_id'];
							
			}

		}
		
		if(
			(
				isset($_SESSION['user']['branch']['active']) &&
				count($_SESSION['user']['branch']['active']) > 1
			)
			 &&
			(
				!isset($_SESSION['user']['branch']['selected']) || 
				empty($_SESSION['user']['branch']['selected'])
			)

		  ) {
		
			header("location:".host."/login/selectbranch");

			return false;
		
		}else{

			if(    !isset($_SESSION['user']['branch']['selected'])) {

				          $_SESSION['user']['branch']['selected'][0] =  

					isset($_SESSION['user']['branch']['active'][0]) ? 

						  $_SESSION['user']['branch']['active'][0] : 
					
					page_lib::access("no branch active");	
			}

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

		$users_branch_data = $this->sql()->tableUsers_branch()->whereUsers_id($this->users_id)
		->andBranch_id($_SESSION['user']['branch']['selected'][0])->limit(1)->select()->assoc();

		
		//------------------------------ set status session
		$_SESSION['user']['type'] = $users_branch_data['type'];
		
		//------------------------------ set status session
		$_SESSION['user']['status'] = $users_branch_data['status'];


		$users_data = $this->sql()->tableUsers()->whereId($this->users_id)->limit(1)->select()->assoc();

		

		//------------------------------ set email session
		$_SESSION['user']['email'] = $users_data['email'];
		

		$sql_person = $this->sql()->tablePerson()->whereUsers_id($this->users_id)->limit(1)->select()->assoc();
		
		//------------------------------ set name session
		$_SESSION['user']['name']   = $sql_person['name'];

		//------------------------------ set family session
		$_SESSION['user']['family'] = $sql_person['family'];
		
		//------------------------------ set gender session
		$_SESSION['user']['gender'] = $sql_person['gender'];


		$this->permission();

	}

	public function permission() {
		// return ;
		$permission = $this->sql()->tablePermission();
		$permission->joinUsers_branch()->whereId("#permission.users_branch_id");
			foreach ($_SESSION['user']['branch']['selected'] as $key => $value) {
				$permission->condition("and" ,"users_branch.branch_id", "=", $value);
			}
		$permission = $permission->select()->allAssoc();


		//------------------------------ set list of permission session
		$session = array();

		foreach ($permission as $key => $value) {
			if($value['select'] != NULL ) $session['tables'][$value["tables"]]['select'] = $value['select'];
			if($value['update'] != NULL ) $session['tables'][$value["tables"]]['update'] = $value['update'];
			if($value['insert'] != NULL ) $session['tables'][$value["tables"]]['insert'] = $value['insert'];
			if($value['delete'] != NULL ) $session['tables'][$value["tables"]]['delete'] = $value['delete'];
			if($value['condition'] != NULL) $session['tables'][$value["tables"]]['condition'] = $value['condition'];
		}

		$_SESSION['user']['permission'] = $session;
	}
}
?>