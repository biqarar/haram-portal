<?php 

/**
* 
*/
class model extends main_model {
		public function post_api(){
			
			$dtable = $this->dtable->table("classes")
			->fields("id", "teacher", "name", "pname")
			->search_fields("pname plan.name" , "name classes.name")
			->query(function($q){
				$q->joinPlan()->whereId("#classes.plan_id")->fieldName('pname');
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