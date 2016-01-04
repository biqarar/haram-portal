<?php
class model extends main_model{
	function post_api(){
		
		$dtable = $this->dtable->table('nezarat_item')
		->fields('id', 'title', 'validation',"group", "description", 'id edit')
		->search_fields('title', 'group')
		->query(function($q){
			// $q->joinProvince()->whereId("#city.province_id")->fieldName('pname');
		})
		// ->order(function($q, $n, $b){
		// 	// if($n === 'orderPname'){
		// 	// 	$q->join->province->orderName($b);
		// 	// }else{
		// 	// 	return true;
		// 	// }
		// })
		->result(function($r){
			$r->edit = '<a class="icoedit" href="nezarat/item/status=edit/id='.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>