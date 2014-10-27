<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		$this->global->page_title = "users_detail";
		$users_detail = $this->sql("#users_detail", $this->xuId());
		// var_dump($this->xuId());
		// var_dump($users_detail);
		// ; exit();
		$ret_users_detail = array();
		foreach ($users_detail[0] as $key => $value) {
			if($value != null) {
				$ret_users_detail[_($key)] = _($value);
			}else{
				$ret_users_detail[_($key)] = $value;
			}
		}
		$person = array();
		foreach ($users_detail[1] as $key => $value) {
			if($value != null) {
				$student1[_($key)] = _($value);
			}else{
				$student1[_($key)] = $value;
			}
		}

		$student1 = array();
		foreach ($users_detail[2] as $key => $value) {
			if($value != null) {
				$student1[_($key)] = _($value);
			}else{
				$student1[_($key)] = $value;
			}
		}
		// $users_detail = $this->sql("#users_detail", $users_detail['users_id']);
		$this->data->list = array($ret_users_detail, $person,  $student1);

	}
} 
?>