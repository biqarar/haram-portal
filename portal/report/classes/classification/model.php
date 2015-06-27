<?php 
		
/**
* @auther reza mohiti
*/
class model extends main_model {
	
	public function sql_classification() {
		var_dump("expression");exit();
		return $this->sql()->tableBridge()->whereTitle("mobile")->select()->allAssoc();



			set_time_limit(30000);
						ini_set('memory_limit', '-1');
						ini_set("max_execution_time", "-1");
			if (ob_get_level() == 0) ob_start();
		$all = array();
		$list = $this->sql()->tableOldclassification()
		->where("date_in", "like", "'%1393%'")
		->or("date_ou", "like", "'%1393%'");

		// $list->joinStudent()->whereName1("#oldclassification.parvande");
		$list = $list->limit(7000,1000)->select()->allAssoc();
		foreach ($list as $key => $value) {
			// var_dump($value);exit();
			$person = $this->sql()->tableStudent()->whereName1($value['parvande'])->select()->assoc();
			$all[$key] = $person;
			$class = $this->sql()->tableOldclasses()->whereCode($value['oldclasses'])->select()->assoc();
			foreach ($class as $k => $v) {
				$all[$key][$k] = $v;
			}
			foreach ($value as $kk => $vv) {
				$all[$key][$kk] = $vv;
			}
			ob_flush();
					flush();
			// array_push($value, $person);
			// var_dump($person, $value);exit();
		}
	ob_end_flush();
		// var_dump($all);exit();
		// var_dump($list->string());exit();
		return $all;





		$classes_id = preg_split("/\,/", $classesid);
		if(!$classesid || empty($classes_id)) return false;
		
		$classification = $this->sql()->tableClassification();
		
		$classification->groupOpen();
		foreach ($classes_id as $key => $value) {
			$classification->orClasses_id($value);
		}
		$classification->groupClose()->fieldId();
		
		$this->classification_finde_active_list($classification);
		
		$classification->joinUsers()->whereId("#classification.users_id")->fieldUsername();

		$classification->joinPerson()->whereUsers_id("#classification.users_id");

		$classification->joinClasses()->whereId("#classification.classes_id")
			->fieldStart_time()
			->fieldEnd_time()
			->fieldStart_date()
			->fieldEnd_date()
			->fieldWeek_days();

		$classification->joinPlan()->whereId("#classes.plan_id")->fieldName("plan");
		
		$classification->joinPlace()->whereId("#classes.place_id")->fieldName("place");
		
		$classification->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue("mobile");

		$x = $classification->groupValue()->select();
		$x = $x->allAssoc();

		return $x;
	}
	public function post_report(){
	
	}	
}
?>