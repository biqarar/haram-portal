<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function post_insert() {
		//------------------------------ set users id and classes id
		$users_id   = config_lib::$surl["usersid"];
		$classes_id = config_lib::$surl["classesid"];
		//------------------------------ key for check duplicate
		$duplicate = false;

		//------------------------------ check for duplicate this classes inserted 
		$check = $this->sql()->tableClassification()->whereUsers_id($users_id)->andClasses_id($classes_id)->limit(1)->select();

		if($check->num() == 0) {
			//------------------------------ check duplicate other classes as time for this users
			if(!$this->duplicate_classes_time()){
				//------------------------------ insert classification
				$classification = $this->sql()->tableClassification()
						->setUsers_id($users_id)
						->setClasses_id($classes_id)
						->setDate_entry($this->dateNow())
						->insert();
				//------------------------------- set classification count in to classes table
				$this->sql(".classesCount", $classes_id);
			}
		}else{

			$duplicate = true;
			debug_lib::msg("duplicate", "اطلاعات تکراری است");
		}	
	
		//------------------------------ commit code
		if(!$duplicate) {
			$this->commit(function() {
				debug_lib::msg("insert","اطلاعات ثبت شد");	
			});
		}

		//------------------------------ rolback code
		$this->rollback(function() {
			debug_lib::msg("failed","خطا در ثبت");
		});
	}

	public function duplicate_classes_time() {
		//------------------------------ set users id and classes id
		$users_id   = config_lib::$surl["usersid"];
		$classes_id = config_lib::$surl["classesid"];

		//------------------------------ duplicate key
		$duplicate = false;

		$error = false;

		$classes_detail = array();

		$new_classes = $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assoc();
		if(!isset($new_classes['id']) || $new_classes['status'] == 'done'){
			debug_lib::msg("failed","اطلاعات کلاس یافت نشد");
		}

		$allClass_users = $this->sql()->tableClassification()->whereUsers_id($users_id)
			->groupOpen()
			->condition("and", "#date_delete" , "is", "#null")
			->condition("or", "#because", "is", "#null")
			->groupClose();

		$allClass_users->joinClasses()->whereId("#classification.classes_id")
			->groupOpen()
			->andStatus("ready")->orStatus("running")
			->groupClose();

		$allClass_users = $allClass_users->select()->allAssoc();
		

		foreach ($allClass_users as $key => $value) {

			$start_date_exist = intval($value['start_date']);
			$end_date_exist   = intval($value['end_date']);
			$start_time_exist = intval($value['start_time']);
			$end_time_exist   = intval($value['end_time']);
			$week_days_exist  = preg_split("/\,/", $value['week_days']);

			$new_start_date   = intval($new_classes['start_date']);
			$new_end_date     = intval($new_classes['end_date']);
			$new_start_time   = intval($new_classes['start_time']);
			$new_end_time     = intval($new_classes['end_time']);
			$new_week_days    = preg_split("/\,/", $new_classes['week_days']);
			
			//------------------------------ save duplicate detail to show
				$classes_detail = $value;
				
				//------------------------------  date end of exist classes > start date of request classes
				if($start_date_exist <= $new_end_date && $end_date_exist >= $new_start_date) {

					//------------------------------ check week days of exist classes and request classes
				
					foreach ($new_week_days as $k => $v) {
						
						if(preg_grep("/" . $v . "/", $week_days_exist)) {

							//------------------------------ check time of exist classes and request classes
							
							if ($end_time_exist > $new_start_time && $start_time_exist < $new_end_time) {

								//------------------------------ duplicate item here !!! 
								// //------------------------------ can not insert users in this class
									$duplicate = true;
							}
						}
						if($duplicate) break;
					}
				}
			if($duplicate) break;
		}

		if($duplicate) {
			debug_lib::msg("failed",
				" این کلاس با کلاس شماره "
				. $classes_detail['classes_id'] .
				" که هم اکنون این فراگیرا در آن ثبت است تداخل دارد " 
				);
		}
		return $duplicate;
	}


	public function convert_time($time = false) {
		$nTime = preg_replace("/\:|\s|\-/", "", $time);
		if(strlen($nTime) < 6) {
			$nTime = $nTime . "00";
		}
		return intval($nTime);
	}

	public function convert_date($date = false) {
		if (!preg_match("/^(\d{4})(\-|\/|)(\d{1,2})(\-|\/|)(\d{1,2})$/", $date, $nDate)) {
			return false;
		}else{
			$date = $nDate[1]
			.
			((intval($nDate[3]) < 10) ? "0".intval($nDate[3]) : intval($nDate[3]))
			.
			((intval($nDate[5]) < 10) ? "0".intval($nDate[5]) : intval($nDate[5]));
		}
		return $date;
	
	}
}
?>