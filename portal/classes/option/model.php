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
		$this->check_duplication();


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
		$duplicate = false;
		$start_time = post::start_time();
		$start_time = intval($start_time);

		$end_time   = post::end_time();
		$end_time = intval($end_time);

		$start_date = post::start_date();
		$start_date = intval($start_date);

		$end_date   = post::end_date();
		$end_date = intval($end_date);

		$place      = post::place_id();
		$week_days  = post::week_days();
		$status     = post::status();

		$class = $this->sql()->tableClasses()
				->groupOpen()
				->whereStatus("ready")->orStatus("running")
				->groupClose()
				->andPlace_id($place)->select();

		if($class->num() > 0 ) {
			$allClass = $class->allAssoc();
			foreach ($allClass as $key => $value) {
				if(intval($value['end_date']) > $start_date) {
					echo "date\n" . $value['end_date']. " > " .$start_date . "\n";
					// die();
				}
				$start_time_exist = $this->convert_time($value['start_time']);
				$end_time_exist = $this->convert_time($value['end_time']);
				// print_r("expression");
				// print_r($start_time_exist);
				// print_r($end_time_exist > $start_time ? "y" : " n");
				// print_r($start_time_exist < $end_time ? "y" : "n");
				if ($end_time_exist > $start_time && $start_time_exist < $end_time) {
					// time interference
					$week_days_exist = preg_split("/\,/", $value['week_days']);
					// $week_days = preg_split("/\,/", $week_days);
					// print_r("expression");
					// print_r($week_days_exist);
					foreach ($week_days as $k => $v) {
						if(preg_grep("/" . $v . "/", $week_days_exist)) {
							// week day interference
							// if($value['end_date'] > $start_date) {
							// print_r("expression");
								$duplicate = true;
							// }
						}
					}

				}
			}	
		}

		if($duplicate) {
			echo "duplicate";

		}else {
			echo "string";
		}
		// print_r($class->allAssoc());
		exit();
	}

	public function convert_time($time = false) {
		return intval(preg_replace("/\:/", "", $time));
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