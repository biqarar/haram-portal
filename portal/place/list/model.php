<?php

class model extends main_model {
	public function post_api() {
		$dt = $this->dtable->table('place')->fields("name", "description","multiclass" ,"id edit")
		->search_fields("name", "description")
		->result(function($r){
			$r->edit = '<a class= "icoedit" href="place/status=edit/id='. $r->edit . '"></a>';
			});
		$this->sql(".dataTable", $dt);
	}
}

?>