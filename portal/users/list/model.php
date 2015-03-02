<?php 
/**
* 
*/
class model extends main_model {
	public function post_api(){
		$type = $this->xuId("type");
		// $type = isset($type) && $type != "" ? $type : "learn";
			// var_dump($type);exit();
		$dtable = $this->dtable->table('person')
			->fields(
				'username',
				'name',
				'family',
				'father',
				'birthday',
				// 'gender',
				'nationalcode',
				'code',
				// 'marriage',
				// 'education_id',
				'users_id detail',
				'users_id learn',
				'users_id')
			->order(function($q, $n, $b){
				if($n === 'orderUsername'){
					$q->join->users->orderUsername($b);
				}else{
					return true;
					$q->orderId($b);
				}
			})
			->search_fields('name', 'family', 'father' , "username users.username" , "nationalcode person.nationalcode")
			->query(function($q){
				$q->joinUsers()->whereId("#person.users_id")->fieldUsername("username");
			})
			// ->search_result(function($result){
			// 	$vsearch = $_GET['search']['value'];
			// 	$vsearch = str_replace(" ", "", $vsearch);
			// 	$result->groupOpen();
			// 	$result->condition("or", "##concat(person.name, person.family, person.father)", "LIKE", "%$vsearch%");
			// 	$result->groupClose();
			// 	$result->condition("or", "users.username", "LIKE", "%$vsearch%");
			// 	$result->condition("or", "person.nationalcode", "LIKE", "%$vsearch%");
			// 	// print_r($result);exit();
			// 	// $result->condition("or" "#person.s", "LIKE" "%$vsearch%");
			// })
			->result(function($r, $type){
				$r->learn = $this->type($type , $r->learn);
				$r->detail = $this->tag("a")->addClass("icomore")->href("users/status=detail/id=". $r->detail)->render();
			}, $type);
		$this->sql(".dataTable", $dtable);
	}	

	public function type($type = false, $id = false) {
		// var_dump($type, $id);exit();
		if($type == "price"  ) {
			return $this->tag("a")
			->addClass("icoprice")->href('price/status=add/usersid='. $id)->render();
		}else{
			return $this->tag("a")->addClass("icoshare")->href('users/learn/id='. $id)->render();
		}
	}
}
?>