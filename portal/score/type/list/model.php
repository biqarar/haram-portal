<?php
class model extends main_model {
	public function post_api() {
		$dtable = $this->dtable->table("score_type")
			->fields("id","name","title", "min","max","description", "id edit")
			->search_fields("name plan.name")
			->query(function($q){
				$q->joinPlan()->whereId("#score_type.plan_id")->fieldName();
			})
			->result(function($r){
				$r->edit = '<a href="score/type/status=edit/id=' . $r->edit . '" class="icoedit" ></a>';
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>