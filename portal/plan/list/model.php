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
				// "expired_price",
				// "payment_count",
				"id edit")
		->search_fields("name", "price")
		->result(function($r){
			$r->edit = '<a class= "icoedit" href="plan/status=edit/id='. $r->edit . '"></a>';
			
		})
		->query(function ($q){
			//---------- get branch id in the list
			foreach ($this->branch() as $key => $value) {
				if($key == 0){
					$q->condition("where", "plan.branch_id","=",$value);
				}else{
					$q->condition("or","plan.branch_id","=",$value);
				}
			}
		});
		$this->sql(".dataTable", $dt);
	}

	function post_apisection() {
		$dt = $this->dtable->table('plan_section')->fields(
				"id",
				"plan",
				"section",
				"id edit")
		->search_fields("section", "plan.name")
		->query(function($q) {
			$q->joinPlan()->whereId("#plan_section.plan_id")->fieldName("plan");
		})
		->result(function($r){
			$r->edit = '<a class= "icoedit" href="plan/section/status=edit/id='. $r->edit . '"></a>';
			
		});
		$this->sql(".dataTable", $dt);

	}
}

?>