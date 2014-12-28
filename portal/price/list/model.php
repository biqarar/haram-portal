<?php 
class model extends main_model {
	public function post_api() {
		
		$dtable = $this->dtable->table("price")
		->fields('id', "users_id", "date", "type", "value", "pay_type" , "transactions" ,"description")
		->search_fields("users_id", "date", "transactions")
		->result(function($r) {
			// $r->edit = '<a class="icoedit" href="price/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

}
?>
