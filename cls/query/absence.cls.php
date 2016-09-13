<?php
class query_absence_cls extends query_cls
{
	public $users_id,$classes_id,$classification_id;

	public function absence_count($array = false) {
		$c = 0;
		foreach ($array as $key => $value) {
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
		return $c;
	}
	public function autoremove($classification_id = false, $date = false) {
		// return;

		$this->classification_id = $classification_id;

		$max_absence = $this->sql()->tableClassification()->whereId($this->classification_id);
		$max_absence->joinClasses()->whereId("#classification.classes_id")->fieldPlan_id("planid");
		$max_absence->joinPlan()->whereId("#classes.plan_id")
								->fieldAbsence("max_absence")
								->fieldAbsence_type("absence_type");

		$max_absence = $max_absence->select()->assoc();
		
		$this->users_id 		= $max_absence['users_id'];
		$this->classes_id 	= $max_absence['classes_id'];
		$absence_type 	= $max_absence['absence_type'];

		if($absence_type == "ماهیانه"){
			
			$x = preg_split("/\-/", $date);
		
			$y = (intval($x[0]) < 10) ? "0" . $x[0] : $x[0];
			$m = (intval($x[1]) < 10) ? "0" . $x[1] : $x[1];
			$d = (intval($x[2]) < 10) ? "0" . $x[2] : $x[2];

			$start_day = "{$y}{$m}01";

			if($m == "12"){
				$new_m = ($m == '12') ? $new_m = '01' :  intval($m) + 1;
				$y = intval($y)+1;
			}else{
				$new_m = ($m == '12') ? $new_m = '01' :  intval($m) + 1;
			}
			
			$new_m = (intval($new_m) < 10) ? "0" . $new_m: $new_m;
		

			$end_day = "{$y}{$new_m}01";

			
			$absenc_list = $this->sql()->tableAbsence()
										->whereClassification_id($this->classification_id)
										->condition("and", "absence.date", ">=", "$start_day")
										->condition("and", "absence.date", "<", "$end_day")
										->select();
			$c = $this->absence_count($absenc_list->allAssoc());

			$this->remove($c, $max_absence['max_absence']);


		}else{

			$absence_count = $this->sql()->tableAbsence()->whereClassification_id($this->classification_id)->select();

			$c = $this->absence_count($absence_count->allAssoc());

			$this->remove($c, $max_absence['max_absence']);	
		}
	}

	public function remove($c =false, $max = false) {
		
		if(intval($c) > intval($max)){
				$this->sql(".classification.remove",
							$this->users_id, 
							$this->classes_id, 
							$this->classification_id ,
							"absence" , 
							$this->dateNow());
			debug_lib::true("<a style='color:red'>فراگیر به دلیل غیبت بیش از حد مجاز از کلاس حذف شد</a>");

		}
	}

}
?>