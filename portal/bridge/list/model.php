<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
		public function post_api(){
		
		$dtable = $this->dtable->table("bridge")
		->fields(
			"name person.name",
			"family person.family",
			"title",
			"value",
			"id edit"
		)
		->search_fields(
			"name", "family", "value"
		)
		->query(function($q){
			$q->joinPerson()->whereUsers_id("#bridge.users_id")->fieldFamily("family")->fieldName("name");
		})
		->result(function($r){
			$r->edit = '<a class="icoedit" href="bridge/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
			// $r->classification = '<a class="icobridge" href="classification/class/bridgeid='.$r->classification.'" title="'.gettext('classification').' '.$r->classification.'"></a>';
			// // $r->absence = '<a class="icoattendance" href="classification/absence/bridgeid='.$r->absence.'" title="'.gettext('absence').' '.$r->absence.'"></a>';
			// $r->detail = '<a class="icomore" href="bridge/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';

		});

		$this->sql(".dataTable", $dtable);
	}	
}
?>