<?php 
/**
* 
*/
class sql_cls {
	static function config($maker = false) {
		//------------------------------ join each query whit branch_cash table (permission)
		if(isset($_SESSION['users_id']) && isset($_SESSION['users_branch'])){

			$users_id = $_SESSION['users_id'];
			
			//------------------------------ public table (no permission set on this tables)
			$freeTable = array("city","province","country","education","permission","login_counter","users","tables","posts_group","posts","branch_users_key");
			
			//------------------------------ called table
			$table = $maker->table;

			if(!preg_grep("/^$table$/", $freeTable)){
				
				//------------------------------ join to permission
				$x = $maker->joinBranch_cash()
					->whereTable($table)
					->andRecord_id("#".$table.".id")
					->groupOpen();

				foreach ($_SESSION['users_branch'] as $key => $value) {
					if($key == 0){
						$x->andBranch_id($value);
					}else{
						$x->orBranch_id($value);
					}
				}
				$x->groupClose();
				$x->fieldId();
				// $x->groupbyTable();
				// $x->groupbyRecord_id();
	
				//------------------------------ paging record limit 200
				if(isset(config_lib::$surl['page']) || (isset(config_lib::$surl['status']) && config_lib::$surl['status'] == "list")){
					$start_page = (isset(config_lib::$surl['page'])) ? ((intval(config_lib::$surl['page']) - 1)* 20) : 0;
					$limit_start = $start_page;
					$limit_end = 200;
					$maker->limit($limit_start, $limit_end);
				}
			}
		}else{
			$users_id = 0;
		}
	}
	static function call($maker, $name){
	
		//------------------------------ send  users_id and branch_id to mysql engine 
		$sql = new dbconnection_lib;

		$users_id = $_SESSION['users_id'];

		if(post::branch_id() && preg_grep("/^".post::branch_id()."$/", $_SESSION['users_branch']) && preg_match("/^\d+$/", post::branch_id())){
		
			$branch_id = post::branch_id();
		
		}elseif(isset($_SESSION['users_branch']) && count($_SESSION['users_branch']) == 1 && !post::branch_id()){
		
			$branch_id = $_SESSION['users_branch'][0];
		
		}elseif(isset($_SESSION['users_branch']) && count($_SESSION['users_branch']) > 1 && !post::branch_id()){
		
			$branch_id = $_SESSION['users_branch'][0];
		
		}else{
		
			$branch_id = 0;
		
		}

		//------------------------------ send users id
		if(isset($_SESSION['users_id'])){
			$q = $sql->query("SET @users_id = ". $_SESSION['users_id']);
			$q = $sql->query("SET @ip_ = ". "'" . $_SERVER['REMOTE_ADDR'] . "'");
			$q = $sql->query("SET @branch_id = ". $branch_id);
		}

		if($name == "insert" || $name == "update" || $name == "delete") {
			$q = $sql->query("CALL insertPerm($users_id, $branch_id)");
		}

	}
}
?>
