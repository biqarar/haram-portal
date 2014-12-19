<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class model extends main_model{

	public function makeQuery() {
		//------------------------------ make sql object

		return $this->sql()->tableClasses()
				->setCourse_id(post::course_id())
				->setPlan_id(post::plan_id())
				->setMeeting_no(post::meeting_no())
				->setAge_range(post::age_range())
				->setQuality(post::quality())
				->setPlace_id(post::place_id())
				->setName(post::name())
				->setStart_time("#'".post::start_time() . "'")
				->setEnd_time("#'".post::end_time(). "'")
				->setTeacher(post::teacher())
				->setStart_date(post::start_date())
				->setEnd_date(post::end_date())
				->setWeek_days(join(post::week_days(), ","))
				->setStatus(post::status());
	}

	public function post_add_classes() {

		//------------------------------ check duplicate classes
		$this->check_duplication();

		//------------------------------ insert classes
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert classes successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert classes failed]]");
		});
	}

	public function post_edit_classes() {


		//------------------------------ check duplicate classes
		if(!$this->check_duplication()){
			// print_r("expression");
			// exit();
		}

		//------------------------------ update classes
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update classes successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update classes failed]]");
		});
	}

	public function check_duplication() {
		//------------------------------ duplicate key
		$duplicate = false;

		//------------------------------  start tiem request
		$start_time = post::start_time();
		$start_time = $this->convert_time($start_time);

		//------------------------------  end time request
		$end_time   = post::end_time();
		$end_time = $this->convert_time($end_time);

		//------------------------------  start date request
		$start_date = post::start_date();
		$start_date = $this->convert_date($start_date);

		//------------------------------ end date request
		$end_date   = post::end_date();
		$end_date = $this->convert_date($end_date);

		//------------------------------  place id
		$place      = post::place_id();

		//------------------------------  week days
		$week_days  = post::week_days();

		//------------------------------ status
		$status     = post::status();

		//------------------------------ sql result for status && place_id query
		$class = $this->sql()->tableClasses()
				->groupOpen()
				->whereStatus("ready")->orStatus("running")
				->groupClose()
				->andPlace_id($place)->select();

		//------------------------------  if in this place classes and ready or running
		if($class->num() > 0 ) {

			$allClass = $class->allAssoc();
			
			foreach ($allClass as $key => $value) {
				
				//------------------------------  date end of exist classes > start date of request classes
				if(intval($value['end_date']) > $start_date) {

					//------------------------------ check week days of exist classes and request classes
					$week_days_exist = preg_split("/\,/", $value['week_days']);

					foreach ($week_days as $k => $v) {
						
						if(preg_grep("/" . $v . "/", $week_days_exist)) {

							//------------------------------ check time of exist classes and request classes
							$start_time_exist = $this->convert_time($value['start_time']);
							$end_time_exist = $this->convert_time($value['end_time']);

							if ($end_time_exist > $start_time && $start_time_exist < $end_time) {
								//------------------------------ duplicate item here !!! 
								//------------------------------ can not insert or update classes
								$duplicate = true;
							}
						}
					}
				}
			}	
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

	/**
	* @return array (liset of users whit teacher type)
	*/
	function sql_users_name_family() {

		$x = $this->sql()->tableUsers();
		$x->whereType('teacher');
		// ->andStatus("enable"); // fase 2
		$x->joinPerson()->whereUsers_id("#users.id");
		$y = $x->select()->allAssoc();

		$ret = array();
		foreach ($y as $key => $value) {
			$ret[$value['users_id']] = $value;
		}
		return $ret;
	}
}
 ?>