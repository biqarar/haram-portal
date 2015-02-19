<?php
class model extends main_model {


	/**
	*	list of field
	* 	whit select score type of plan
	*/
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

		$list = $this->sql(".scoreCalculation.score_classes",$classesid);

	
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


}
?>