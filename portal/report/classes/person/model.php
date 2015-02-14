<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	
	public function sql_bridge_list($classesid = false) {
		
		$classes_id = preg_split("/\,/", $classesid);

		if(!$classesid || empty($classes_id)) return false;
		
		$reprot = array();
		foreach ($classes_id as $key => $value) {
			
			$classes_detail = $this->sql()->tableClasses()->whereId($value)
				->fieldStart_time()
				->fieldEnd_time()
				->fieldStart_date()
				->fieldEnd_date()
				->fieldWeek_days()
				->fieldCount();

			$classes_detail->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teacherName")->fieldFamily("teacherFamily");
			
			$classes_detail->joinPlan()->whereId("#classes.plan_id")->fieldName("plan");
		
			$classes_detail->joinPlace()->whereId("#classes.place_id")->fieldName("place");
	
			$classes_detail = $classes_detail->limit(1)->select()->assoc();
		
			$classes_detail['male'] = $this->sql(".reports.person_classes", $value, "gender=male");
			
			$classes_detail['female'] = $this->sql(".reports.person_classes", $value, "gender=female");

			$classes_detail['single'] = $this->sql(".reports.person_classes", $value, "marriage=single");
			
			$classes_detail['married'] = $this->sql(".reports.person_classes", $value, "marriage=married");
			
			$classes_detail['average_age'] = $this->sql(".reports.classes_average_age", $value);


			$reprot[$key] = $classes_detail;

		}

		return $reprot;

		
		var_dump($reprot);
		exit();
		//------------------------------ find lis of person in classes
		$classification = $this->sql()->tableClassification()
		->groupOpen()
			->condition("and", "#date_delete" , "is", "#null")
			->condition("or", "#because", "is", "#null")
		->groupClose()
		->groupOpen();

		//------------------------------ all classes_id (is called)
		foreach ($classes_id as $key => $value) {
			$classification->orClasses_id($value);
		}
		
		$classification->groupClose()->fieldId();

		//------------------------------ find urers
		$classification->joinUsers()->whereId("#classification.users_id")->fieldUsername();


		// $classification->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("name")->fieldFamily("family");

		$classification->joinClasses()->whereId("#classification.classes_id")
			->fieldStart_time()
			->fieldEnd_time()
			->fieldStart_date()
			->fieldEnd_date()
			->fieldWeek_days();

		$classification->joinPlan()->whereId("#classes.plan_id")->fieldName("plan");
		
		$classification->joinPlace()->whereId("#classes.place_id")->fieldName("place");

		$classification->joinPerson()->whereUsers_id("#classification.users_id");
		
		
		
		// $classification->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue("mobile");


		// var_dump("d");exit();

		$x = $classification->groupValue()->select();
		// echo($x->string());exit();
		$x = $x->allAssoc();
		var_dump($x);exit();
		return $x;
		

	}
	public function post_report(){
	
	}	
}
?>