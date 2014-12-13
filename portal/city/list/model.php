<?php
class model extends main_model{
	function post_api(){
		
		$this->dtable->table('city')
		->fields('id', 'name', 'pname', 'id edit')
		->search_fields('name', 'pname')
		->query(function($q){
			$q->joinProvince()->whereId("#city.province_id")->fieldName('pname');
		})
		->order(function($q, $n, $b){
			if($n === 'orderPname'){
				$q->join->province->orderName($b);
			}else{
				return true;
			}
		})
		->result(function($r){
			$r->edit = '<a class="icoedit ui-draggable ui-draggable-handle" href="city/status=edit/id='.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>