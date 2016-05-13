<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public $main_users_id = false;
	public $duplicate_users_id = array();
	public $users_id = array();
	public $nationalcode = false;
	public $show = array();

	public function _get_delete(){
		$table = get::table();
		$status = get::status();
		$id = get::id();
		if($status == "delete"){
			$x = "table" .ucfirst($table);
			$query = $this->sql()->$x()->whereId($id)->delete();
			// echo "result: ". $query->result();
			// echo "<br> error : " . $query->error();
			// echo "<br> query: " . $query->string();
			$this->commit(function(){

				var_dump(debug_lib::complie());exit();
				debug_lib::true("ok");
			});
			$this->rollback(function(){


				var_dump(debug_lib::complie());exit();
				debug_lib::fatal("fuck");
			});
			
		}
		// var_dump($_GET);exit() 	;
	}

	public function sql_duplicate($nationalcode = false ){
		// var_dump(":|");exit();
		$this->nationalcode = $nationalcode;
		//----------- if get the url delete it
		$this->_get_delete();
		
		//------------------ fund person whit this nationalcode
		$dbl_person = $this->sql()->tablePerson()->whereNationalcode($nationalcode)->select();

		//------------------ if duplicate is true
		if ($dbl_person->num() > 1) {
			$dbl_person = $dbl_person->allAssoc();
			//-------------- show data
			$this->table($dbl_person, "person");
			//-------------- list of table muse be change
			$show_table = array("bridge","price","classification", "users_branch");
			$ret = array();
			foreach ($dbl_person as $key => $value) {
				//---------------- save users_id
				$this->users_id[] = $value['users_id'];

				if(!$this->main_users_id){
					$this->main_users_id = $value['users_id'];
				}else{
					$this->duplicate_users_id[] = $value['users_id'];
				}

				$x = $this->sql()->tableUsers()->whereId($value['users_id'])->limit(1)->select()->assoc();
				array_push($ret, $x);
			}

			$this->table($ret, "users");

			foreach ($show_table as $key => $value) {
				$x = "table" . ucfirst($value);
				$sql = $this->sql()->$x();
				foreach ($dbl_person as $k => $v) {
					if($k == 0){
						$sql->whereUsers_id($v['users_id']);
					}else{
						$sql->orUsers_id($v['users_id']);
					}
					
				}
			$sql = $sql->select()->allAssoc();
			$this->table($sql, $value);
		}

			


		}
		return $this->show;

	
	}

	public function table($array, $title){
		// return ;
		// var_dump($array);
		$href ="database/status=removeduplicate/nationalcode=" . $this->nationalcode;
		$echo = "<h3>$title</h3>";
		$echo .= "<table border=1>";
		foreach ($array as $key => $value) {
			$echo .= "<tr>";
			if($key == 0){
					$echo .= "<th>";
					$echo .= "num";
					$echo .= "</th>";
				
				foreach ($value as $k => $v) {
					$echo .= "<th>";
					$echo .= $k;
					$echo .= "</th>";
				}
				
					$echo .= "<tr>";
					$echo .= "<th>";
					$echo .= $key;
					$echo .= "</th>";

				foreach ($value as $k => $v) {
					if($k == 0) {
						$v = "<a href='$href?table=$title&status=delete&id=$v'>$v</a>";
					}
					$echo .= "<td>";
					$echo .= $v;
					$echo .= "</td>";
				}
				$echo .= "</tr>";
			}else{
				$echo .= "<th>";
					$echo .= $key;
					$echo .= "</th>";
				foreach ($value as $k => $v) {
					if($k == 0) {
						$v = "<a href='$href?table=$title&status=delete&id=$v'>$v</a>";
					}
					$echo .= "<td>";
					$echo .= $v;
					$echo .= "</td>";
				}

			}
			$echo .= "</tr>";
		}
		$echo .= "</table>";
		$this->show[] = $echo;
	}
}
?>