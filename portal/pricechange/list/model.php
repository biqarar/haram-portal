<?php
class model extends main_model {
	public function post_api() {
		$dtable = $this->dtable->table("price_change")
			->fields("id", "name" , "type", "id edit")
			->search_fields("name")
			->result(function($r){
				$r->edit = '<a href="pricechange/status=edit/id=' . $r->edit . '" class="icoedit" ></a>';
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>