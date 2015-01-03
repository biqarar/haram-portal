<?php
class global_cls{
	static function supervisor(){
		if(isset($_SESSION['user_permission']['tables']['branch']['condition'])
		&&  $_SESSION['user_permission']['tables']['branch']['condition'] = "*"){
			return true;
			// return false;
		}
		return false;
	}
}
?>