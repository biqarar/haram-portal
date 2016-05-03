<?php

class model extends main_model {
	public function post_api() {
		$dt = $this->dtable->table('place')->fields("name", "description","multiclass" ,"id edit")
		->search_fields("name", "description")
		->query(function ($q){
			//---------- get branch id in the list
			foreach ($this->branch() as $key => $value) {
				if($key == 0){
					$q->condition("where", "place.branch_id","=",$value);
				}else{
					$q->condition("or","place.branch_id","=",$value);
				}
			}
		})
		->result(function($r){
			$r->edit = '<a class= "icoedit" href="place/status=edit/id='. $r->edit . '"></a>';
			});
		$this->sql(".dataTable", $dt);
	}
}

?>