<?php
class model extends main_model {
	public function post_api() {
		$dtable = $this->dtable->table("score_type")
			->fields("id","name","title", "min","max","description", "id edit")
			->search_fields("name plan.name")
			->order(function($q, $n, $b){
			if($n === 'orderName'){
				$q->join->plan->orderName($b);
			}else{
				$q->orderId("DESC");	
			}
		})
			->query(function($q){
				$q->joinPlan()->whereId("#score_type.plan_id")->fieldName();
				//---------- get branch id in the list
				foreach ($this->branch() as $key => $value) {
					if($key == 0){
						$q->condition("where", "plan.branch_id","=",$value);
					}else{
						$q->condition("or","plan.branch_id","=",$value);
					}
				}
			})
			->result(function($r){
				$r->edit = '<a href="score/type/status=edit/id=' . $r->edit . '" class="icoedit" ></a>';
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>