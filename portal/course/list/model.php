<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function post_api() {

		$dtable = $this->dtable->table("course")
		->fields("begin_time", "end_time", "name", "id edit")
		->search_fields("begin_time", "end_time", "name")
		->result(function($r) {
			$r->edit = '<a class="icoedit" href="course/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}
}
?>