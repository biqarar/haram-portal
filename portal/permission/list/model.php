<?php 
class model extends main_model {
	public function post_api() {
		
		$dtable = $this->dtable->table("permission")
		->fields("id","username", "users_id", "tables", "select", "insert", "update", "delete", "condition", "id edit")
		->search_fields("users_id", "username", "tables")
		->query(function($q){
			$q->joinUsers()->whereId("#permission.users_id")->fieldUsername("username");
		})
		->result(function($r) {
			$r->edit = '<a class="icoedit" href="permission/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>
