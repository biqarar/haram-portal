<?php 

/**
* 
*/
class model extends main_model {
		public function post_api(){
			
			$dtable = $this->dtable->table("classes")
			->fields("id", "teacher", "name", "pname")
			->search_fields("pname" , "name")
			->query(function($q){
			$q->joinPlan()->whereId("#classes.plan_id")->fieldName('pname');
			})
			->result(function($r){
				// $r->edit = '<a class="icoedit ui-draggable ui-draggable-handle" href="branch/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';

			});
			$this->sql(".dataTable", $dtable);
	}	
}
?>