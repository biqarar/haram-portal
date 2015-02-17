<?php 
class model extends main_model {
	public function post_api() {
		
		$dtable = $this->dtable->table("permission")
		->fields(
			"id",
			"username",
			"name",
			"family",
			 "users_id",
			 "tables",
			 "select",
			 "insert",
			 "update",
			 "delete",
			 "condition",
			 "id edit")
		->search_fields(
			"username",
			"name",
			"family",
			"tables")
		->query(function($q){
			$q->joinUsers()->whereId("#permission.users_id")->fieldUsername("username");
			$q->joinPerson()->whereUsers_id("#permission.users_id")->fieldName("name")->fieldFamily("family");
		})
		->result(function($r) {
			$r->edit = '<a class="icoedit" href="permission/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>
