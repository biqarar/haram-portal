<?php
class query_setLoginSession_cls extends query_cls {
	
	/**
	* @param sql object whit select users id
	*/
	public function config($users_query = false) {
		$users_query             = $users_query->assoc();
		$users_id                = $users_query['id'];

		//------------------------------ set status session
		$_SESSION['users_status'] = $users_query['status'];

		//------------------------------ set email session
		$_SESSION['users_email'] = $users_query['email'];

		$sql_person =  $this->sql()->tablePerson()->whereUsers_id($users_id)->limit(1)->select()->assoc();
		
		//------------------------------ set name session
		$_SESSION['users_name']   = $sql_person['name'];

		//------------------------------ set family session
		$_SESSION['users_family'] = $sql_person['family'];
		
		//------------------------------ set gender session
		$_SESSION['users_gender'] = $sql_person['gender'];

		//------------------------------ set type session (student, operator, teacher, child)
		$_SESSION['users_type'] = $sql_person['type'];

		//------------------------------ set users_id session
		$_SESSION['users_id']     = $users_id;
		

		$users_branch = $this->sql()->tableUsers_branch()->whereUsers_id($users_id)->select()->allAssoc();
		foreach ($users_branch as $index => $value) {
			//------------------------------ set branch_id  session (all branch for this user)
			$_SESSION['users_branch'][] = $value['branch_id'];
		}

		//------------------------------ set list of permission session
		$session = array();
		$permission = $this->sql()->tablePermission()->whereUsers_id($users_id)->select()->allAssoc();

		foreach ($permission as $key => $value) {
			if($value['select'] != NULL ) $session['tables'][$value["tables"]]['select'] = $value['select'];
			if($value['update'] != NULL ) $session['tables'][$value["tables"]]['update'] = $value['update'];
			if($value['insert'] != NULL ) $session['tables'][$value["tables"]]['insert'] = $value['insert'];
			if($value['delete'] != NULL ) $session['tables'][$value["tables"]]['delete'] = $value['delete'];
			// if($value['condition'] != NULL ) $session['tables'][$value["tables"]]['condition'] = $value['condition'];
				
		}
		
		$_SESSION['user_permission'] = $session;
	}
}
?>