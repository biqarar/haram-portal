<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="show score classes";
		$classesid = $this->xuId("classesid");
		$this->score_classes($classesid);

	}

	public function _eval($arg = false) {
		$run = false;
		$list = array();
		foreach ($arg as $key => $value) {
			if(is_array($value)) {
				$run = true;
				foreach ($value as $k => $v) {
					if($k == 'score_type_id' || $k == 'value' || $k == 'title'){
						$list[$value['users_id']][$k][] = $v;
					}
				}	
			}
		}
		if($run) {
			$calculation = $arg[0]['calculation'];
			foreach ($list as $key => $value) {
				foreach ($value as $k => $v) {
					// var_dump($k, $v);
				}
			}
			// var_dump($calculation);
		}
		var_dump($list);
	}

	public function score_classes($classesid = false) {
		$x = ($this->sql("#find_calculation",$classesid));
		$this->_eval($x);
		// var_dump($x); 
		exit();
	}
}
?>