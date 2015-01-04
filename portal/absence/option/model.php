<?php
/**
* @author reza mohiti
*/
class model extends main_model {

	public function sql_classes_name($classes_id = false) {
		$return = $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->fieldId();
		$return->joinPlan()->whereId("#classes.plan_id")->fieldName("plan_name");
		$return->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teacher_name")->fieldFamily("teacher_family");
		$return->joinPlace()->whereId("#classes.place_id")->fieldName("place_name");
		$return = $return->select()->assoc();
		$return = " کلاس شماره " . $return['id'] . ': '. 
				 $return["plan_name"] . " ، استاد " . 
				 $return["teacher_name"] . "  " . 
				 $return["teacher_family"] . " ، " . 
				 $return["place_name"] ;

		return $return;
	}

	public function sql_active_classes($usersid = false) {
		$allClass_users = $this->sql()->tableClassification()->whereUsers_id($usersid)->fieldId("classification_id")
			->groupOpen()
			->condition("and", "#date_delete" , "is", "#null")
			->condition("or", "#because", "is", "#null")
			->groupClose();

		$allClass_users->joinClasses()->whereId("#classification.classes_id")->fieldId("classes_id")
			->groupOpen()
			->andStatus("ready")->orStatus("running")
			->groupClose();

		$allClass_users = $allClass_users->select()->allAssoc();
		return $allClass_users;
	}

	public function makeQuery() {
		//------------------------------ make sql object
		 return $this->sql()->tableAbsence()
				->setDate(post::date())
				->setBecause(post::because())
				->setType(post::type());
	}

	public function post_add_absence(){
		
		foreach ($_POST as $key => $value) {
			if(preg_match("/^classes\_(\d+)$/", $key)){
				//------------------------------ insert absence
				$sql = $this->makeQuery()->setClassification_id($value)->insert();
			}
		}

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert absence successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert absence failed]]");
		});
	}

	public function post_edit_absence() {

		//------------------------------ edit absence
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update absence successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update absence failed]]");
		});
	}
}
 ?>