<?php
class query_setLoginSession_cls extends query_cls {
	
	public function config($users_query = false) {
		$users_query             = $users_query->assoc();
		$users_id                = $users_query['id'];
		$_SESSION['users_email'] = $users_query['email'];

		$sql_person =  $this->sql()->tablePerson()->whereUsers_id($users_id)->limit(1)->select()->assoc();
		$_SESSION['users_name']   = $sql_person['name'];
		$_SESSION['users_family'] = $sql_person['family'];
		$_SESSION['gender'] = $sql_person['gender'];
		$_SESSION['users_id']     = $users_id;
		// var_dump($sql_person);
		// exit();
		// set list of branch 
		$users_branch = $this->sql()->tableUsers_branch()->whereUsers_id($users_id)->select()->allAssoc();
		foreach ($users_branch as $index => $value) {
			$_SESSION['users_branch'][] = $value['branch_id'];
		}
		$session = array();
		$tables = $this->sql()->tableTables()->select()->allAssoc("id");
		$permission = $this->sql()->tablePermission()->whereUsers_id($users_id);
		$permission = $permission->select()->allAssoc();
		foreach ($permission as $key => $value) {
			if($value['select'] != NULL ) $session['tables'][$value["tables"]]['select'] = $value['select'];
			if($value['update'] != NULL ) $session['tables'][$value["tables"]]['update'] = $value['update'];
			if($value['insert'] != NULL ) $session['tables'][$value["tables"]]['insert'] = $value['insert'];
			if($value['delete'] != NULL ) $session['tables'][$value["tables"]]['delete'] = $value['delete'];
			// if($value['condition'] != NULL ) $session['tables'][$value["tables"]]['condition'] = $value['condition'];
				
		}
		$_SESSION['user_permission'] = $session;
		// var_dump($_SESSION);
		// exit();
	}
}
?>