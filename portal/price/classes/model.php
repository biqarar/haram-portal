<?php
class model extends main_model {
	public function post_api() {

		$dtable = $this->dtable->table("classification")
			
			->fields(
			"username users.username",
			"name person.name",
			"family person.family",
			"date_entry",
			"date_delete",
			"because",
			"users_id cash",
			"users_id more")
			
			->search_fields("username", "name", "family")
			->query(function($q){

				$q->andClasses_id($this->xuId("classesid"));
				$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("name")->fieldFamily("family");
				$q->joinUsers()->whereId("#classification.users_id")->fieldUsername("username");
			
			})
			->search_result(function($result){
				$vsearch = $_POST['search']['value'];
				$vsearch = str_replace(" ", "_", $vsearch);
				$result->condition("and", "##concat(person.name, person.family)", "LIKE", "%$vsearch%");
			})
			->result(function($r){
				$r->more = $this->tag("a")->addClass("icomore")->href("price/status=detail/usersid=". $r->more)->render();
				$cash = $this->sql(".price.sum_price", $r->cash);
				$cash = $cash['sum_active'];
				if($cash < 0) {
					$r->cash = $this->tag("a")->vtext($cash)->style("color :red;")->render();
				}else{
					$r->cash = $this->tag("a")->vtext($cash)->style("color :green;")->render();
				}
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>