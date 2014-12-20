<?php
class global_cls{
	static function supervisor(){
		if($_SESSION['user_permission']['tables']['branch']['condition'] = "*"){
			return true;
		}
		return false;
	}
}
?>