<?php
class model extends main_model {

	public function find_calculation($classesid = false) {
		$calculation = $this->sql()->tableClasses()->whereId($classesid)->fieldId();
		$calculation->joinPlan()->whereId("#classes.plan_id")->fieldId();
		$calculation->joinScore_calculation()->wherePlan_id("#classes.plan_id")->andStatus("active");
		$calculation->joinClassification()->whereClasses_id("#classes.id")
		               	->groupOpen()
						->condition("and", "#date_delete" , "is", "#null")
						->condition("or", "#because", "is", "#null")
						->groupClose()
		               	 ->fieldId();
		$calculation->joinScore()->whereClassification_id("#classification.id")->fieldValue();
		$calculation->joinScore_type()->whereId("#score.score_type_id")->fieldTitle();
		$calculation->joinPerson()->whereUsers_id("classification.users_id")->fieldName()->fieldFamily();
		$calculation->joinUsers()->whereId("#classification.users_id")->fieldUsername("username")->fieldId("users_id");
		$calculation = $calculation->select()->allAssoc();
		
		return $calculation;
	}

	public function sql_score_type($classesid = false) {
		$plan_id = $this->sql()->tableClasses()->whereId($classesid)->limit(1)->fieldPlan_id()->select()->assoc("plan_id");
		$score_type = $this->sql()->tableScore_type()->wherePlan_id($plan_id)->select()->allAssoc();
		return $score_type;
	}

	public function sql_field_list($classesid = false) {
		$calculation = $this->sql()->tableClasses()->whereId($classesid)->fieldId();
		$calculation->joinPlan()->whereId("#classes.plan_id")->fieldId();
		$calculation->joinScore_type()->wherePlan_id("#plan.id")->fieldTitle();
		$list = $calculation->select()->allAssoc();
		
		$field_list = array("username users.username", "pname person.name", "family person.family");
		
		foreach ($list as $key => $value) {
			array_push($field_list, "users_id " . $value['title']);
		}

		array_push($field_list, "users_id score");
		
		return $field_list;
	}

	public function post_api() {

		$classesid = $this->xuId("classesid");

		$list = $this->score_classes($classesid);

		$score_type = $this->sql_score_type();
		
		$dtable = $this->dtable->table("classification")
			->fields($this->sql_field_list($classesid))
			->search_fields("username", "name person.name", "family person.family")
			->query(function($q){

				$q->andClasses_id($this->xuId("classesid"));
				$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("pname")->fieldFamily("family");
				$q->joinUsers()->whereId("#classification.users_id")->fieldUsername("username");
			
			})
			->search_result(function($result){
				$vsearch = $_GET['search']['value'];
				$vsearch = str_replace(" ", "_", $vsearch);
				$result->condition("and", "##concat(person.name, person.family)", "LIKE", "%$vsearch%");
			})
			->result(function($r, $list){

				if(is_array($list) && !empty($list)){

					foreach ($list as $key => $value) {
						foreach ($value['title'] as $k => $v) {
							$x = $r->users_id;
							$r->$v = isset($list[$x]['value'][$k]) ? $list[$x]['value'][$k] : "-";
						}
						break;
					}

					$x = $r->users_id;
					$r->score = isset($list[$x]['result']) ? $list[$x]['result'] : "-" ;
				
				}


			}, $list);

			$this->sql(".dataTable", $dtable);
	}


	public function _eval($arg = false) {
		$run = false;
		$list = array();
		foreach ($arg as $key => $value) {
			if(is_array($value)) {
				$run = true;
				foreach ($value as $k => $v) {
					if($k == 'value' 
					|| $k == 'title'
					|| $k == 'name'
					|| $k == 'family'
					|| $k == 'username' ){
						$list[$value['users_id']][$k][] = $v;
					}
				}	
			}
		}
		if($run) {
			$calculation = $arg[0]['calculation'];
			foreach ($list as $key => $value) {
				$x = $calculation;
				
				foreach ($value['title'] as $k => $v) {
					$x = preg_replace("/\=". $v ."\=/", $value['value'][$k], $x);
				}				
				$list[$key]['result'] = (@eval("return " . $x . ";" ) ? @eval("return " . $x . ";" ) : "-");
			}
			return $list;
		}
	}
		 
	public function score_classes($classesid = false) {
		return $this->_eval($this->find_calculation($classesid));
	}
}
?>