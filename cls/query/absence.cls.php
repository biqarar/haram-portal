<?php
class query_absence_cls extends query_cls
{
	public function autoremove($classification_id = false) {
		// return;
		$absence_count = $this->sql()->tableAbsence()->whereClassification_id($classification_id)->select();

		$c = 0;
		foreach ($absence_count->allAssoc() as $key => $value) {
			// var_dump($value);
			switch ($value['type']) {
				case 'delay':
					$c = $c + 0;
					break;
				
				case 'leave':
					$c = $c + 0.5;
					break;

				case 'justified absence':
					$c = $c + 0.5;
					break;

				case 'unjustified absence':
					$c = $c + 1;
					break;
			}
		}


		$max_absence = $this->sql()->tableClassification()->whereId($classification_id);
		$max_absence->joinClasses()->whereId("#classification.classes_id")->fieldPlan_id("planid");
		$max_absence->joinPlan()->whereId("#classes.plan_id")->fieldAbsence("max_absence");
		$max_absence = $max_absence->select()->assoc();
		
		$users_id = $max_absence['users_id'];
		$classes_id = $max_absence['classes_id'];

		if(intval($c) > intval($max_absence['max_absence'])){
			$this->sql(".classification.remove",
						$users_id, $classes_id, $classification_id ,"absence" , $this->dateNow());
			debug_lib::true("<a style='color:red'>فراگیر به دلیل غیبت بیش از حد مجاز از کلاس حذف شد</a>");
		}

		// var_dump($max_absence);
		// var_dump($c);
		// exit();

	}






}
?>