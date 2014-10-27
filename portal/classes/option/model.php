<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableClasses()
				->setCourse_id(post::course_id())
				->setPlan_id(post::plan_id())
				->setMeeting_no(post::meeting_no())
				->setAge_range(post::age_range())
				->setQuality(post::quality())
				->setPlace_id(post::place_id())
				->setName(post::name())
				->setStart_time(post::start_time())
				->setTeacher(post::teacher())
				->setEnd_time(post::end_time())
				->setStart_date(post::start_date())
				->setEnd_date(post::end_date())
				->setWeek_days(post::week_days())
				->setStatus(post::status());
	}
	public function post_add_classes() {
		$sql = $this->makeQuery()
				->insert();
				// print_r($_POST);
				// print_r($sql->string());
				// exit();
		$this->commit(function() {
			debug_lib::true("[[insert classes ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert classes failed]]");
		});
	}

	public function post_edit_classes() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update classes ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update classes failed]]");
		});
	}

	function sql_users_name_family() {
		$query =  $this->sql()->tablePerson()->whereType('teacher')->select()->allAssoc();
		$ret = array();
		foreach ($query as $key => $value) {
			$ret[$value['users_id']] = $value;
		}
		return $ret;
	}
}
 ?>