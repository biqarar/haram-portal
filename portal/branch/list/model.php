<?php 
class model extends main_model {
	public function post_api() {
		
		$this->dtable->table("branch")
		->fields('id', 'name', 'gender', "id edit")
		->search_fields("name", "gender")
		->result(function($r) {
			$r->edit = '<a class="icoedit ui-draggable ui-draggable-handle" href="branch/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>
