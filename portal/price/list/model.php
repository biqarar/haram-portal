<?php 
class model extends main_model {
	public function post_api() {
		
		$dtable = $this->dtable->table("price")
		->fields('id', "users_id", "date", "pay_type", "value" , "pricechangename" , "transactions" ,"description")
		->search_fields("users_id", "date", "transactions")
		->query(function($q){
			$q->joinPrice_change()->whereId("#price.title")->fieldName("pricechangename");
		})
		->order(function($q, $n, $b){
			if($n === 'orderPricechangename'){
				$q->join->price_change->orderName($b);
			}else{
				return true;
			}
		})
		->result(function($r) {
			// $r->edit = '<a class="icoedit" href="price/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>
