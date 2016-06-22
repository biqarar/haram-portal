<?php
class global_cls{

	static function supervisor(){
		if(isset($_SESSION['user']['permission']['tables']['branch']['condition'])
		&&  $_SESSION['user']['permission']['tables']['branch']['condition'] = "*"){
			return true;
		}
		return false;
	}

	static function superprice($condition = false) {
		
		if(isset($_SESSION['user']['permission']['tables']['price']['condition'])){
			
			$price = $_SESSION['user']['permission']['tables']['price']['condition'];

			switch ($condition) {
				case 'classification':
					if(isset($price['classification'])){
						return true;
					}
					// break;

				case 'rule':
					if(isset($price['rule'])){
						return true;
					}
					// break;

				default:
					if($price == "*"){
						return true;
					}
					break;
			}
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