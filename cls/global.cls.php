<?php
class global_cls{

	static function supervisor(){
		if(isset($_SESSION['user']['permission']['tables']['branch']['condition'])
		&&  $_SESSION['user']['permission']['tables']['branch']['condition'] = "*"){
			return true;
		}
		return false;
	}

	static function superprice() {

		if(isset($_SESSION['user']['permission']['tables']['price']['condition'])
		&&  $_SESSION['user']['permission']['tables']['price']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}

	static function superperson() {
		if(isset($_SESSION['user']['permission']['tables']['person']['condition'])
		&&  $_SESSION['user']['permission']['tables']['person']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}
	

	static function superclassification() {
		if(isset($_SESSION['user']['permission']['tables']['classification']['condition'])
		&&  $_SESSION['user']['permission']['tables']['classification']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}

	static function supercertification() {
		if(isset($_SESSION['user']['permission']['tables']['certification']['condition'])
		&&  $_SESSION['user']['permission']['tables']['certification']['condition'] = "*"){
			return true;
		}
		return self::supervisor();
	}
}
?>