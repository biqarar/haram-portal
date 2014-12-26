<?php 
class model extends main_model {
	public function post_api() {
		
		$dtable = $this->dtable->table("permission")
		->fields("id", "users_id", "tables", "select", "insert", "update", "delete", "id edit")
		->search_fields("tables", "users_id")
		->result(function($r) {
			$r->edit = '<a class="icoedit" href="permission/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>
