<?php
class global_cls{
	static function supervisor(){
		if(isset($_SESSION['user_permission']['tables']['branch']['condition'])
		&&  $_SESSION['user_permission']['tables']['branch']['condition'] = "*"){
			// return false;
			return true;
		}
		return false;
	}

	static function superprice() {

		if(isset($_SESSION['user_permission']['tables']['price']['condition'])
		&&  $_SESSION['user_permission']['tables']['price']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}

	static function superperson() {
		if(isset($_SESSION['user_permission']['tables']['person']['condition'])
		&&  $_SESSION['user_permission']['tables']['person']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}
	

	static function superclassification() {
		if(isset($_SESSION['user_permission']['tables']['classification']['condition'])
		&&  $_SESSION['user_permission']['tables']['classification']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}
}
?>