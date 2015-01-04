<?php 
/**
* 
*/
class model extends main_model {
	public function post_api(){

		$dtable = $this->dtable->table('person')
			->fields(
				'username users.username',
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
			->result(function($r){
				$r->learn = $this->tag("a")->addClass("icoshare")->href('users/learn/id='. $r->learn)->render();
				$r->detail = $this->tag("a")->addClass("icomore")->href("users/status=detail/id=". $r->detail)->render();
			});
		$this->sql(".dataTable", $dtable);
	}	
}
?>