<?php

class model extends main_model {
	public function post_api() {
		$dt = $this->dtable->table('plan')->fields(
				"group_id",
				"name",
				"price",
				"absence",
				"certificate",
				"mark",
				"min_person",
				"max_person",
				"id edit")
		->search_fields("name", "price")
		->result(function($r){
			
		});
		$this->sql(".dataTable", $dt);
	}
}

?>