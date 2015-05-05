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
				"expired_price",
				"payment_count",
				"id edit")
		->search_fields("name", "price")
		->result(function($r){
			$r->edit = '<a class= "icoedit" href="plan/status=edit/id='. $r->edit . '"></a>';
			
		});
		$this->sql(".dataTable", $dt);
	}
}

?>