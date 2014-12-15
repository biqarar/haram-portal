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