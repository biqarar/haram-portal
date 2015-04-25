<?php
class model extends main_model {
	public function post_api() {
		$dtable = $this->dtable->table("score_calculation")
			->fields("id", "name","calculation", "status", "description", "id edit")
			->search_fields("name")
			->order(function($q, $n, $b){
				if($n === 'orderName'){
					$q->join->plan->orderName($b);
				}else{
					return true;	
				}
			})
			->query(function($q){
				$q->joinPlan()->whereId("#score_calculation.plan_id")->fieldName();
			})
			->result(function($r){
				$r->edit = '<a href="score/calculation/status=edit/id=' . $r->edit . '" class="icoedit" ></a>';
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>