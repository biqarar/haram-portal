<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
		public function post_api(){
			
			$dtable = $this->dtable->table("classes")
			->fields(
				"planname",
				"teachername",
				"teacherfamily",
				"placename",
				"meeting_no",
				"age_range",
				"quality",
				"start_time",
				"end_time",
				"start_date",
				"end_date",
				"week_days",
				"name",
				"status",
				"type")
			->search_fields(
				"planname plan.name" ,
				"teacherfamily person.family",
				"placename place.name",
				"meeting_no",
				"age_range",
				"quality",
				"start_time",
				"end_time",
				"start_date",
				"end_date",
				"week_days",
				"name",
				"status",
				"type")
			->query(function($q){
				$q->joinPlan()->whereId("#classes.plan_id")->fieldName('planname');
				$q->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teacherfamily");
				$q->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
			})
			->result(function($r){
				// $r->edit = '<a class="icoedit ui-draggable ui-draggable-handle" href="branch/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';

			});

			$this->sql(".dataTable", $dtable);
	}	
}
	// SELECT `classes`.*, `plan`.`name` AS pname, `branch_cash`.`id`
	// FROM `classes`
	// INNER JOIN plan ON
	// `plan`.`id` = classes.plan_id
	// INNER JOIN branch_cash ON
	// `branch_cash`.`table` = 'classes' AND `branch_cash`.`record_id` = classes.id AND(`branch_cash`.`branch_id` = 1 OR `branch_cash`.`branch_id` = 2 OR `branch_cash`.`branch_id` = 3)
	// WHERE concat(pname, " ", name) LIKE '%ی%' ORDER BY `classes`.`id` ASC LIMIT 0, 10
?>