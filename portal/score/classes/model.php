<?php
class model extends main_model {

	public function post_api() {

		
		$array = array("usersid more","username users.username","name person.name", "family person.family","id input");
	
		$dtable = $this->dtable->table("classification")
			->fields($array)
			->search_fields("username users.username","name person.name", "family person.family")
			->order(function($q, $n, $b){
				if($n === 'orderUsername'){
					$q->join->users->orderUsername($b);
				}elseif($n === 'orderName'){
					$q->join->person->orderNamee($b);
				}elseif($n === 'orderFamily'){
					$q->join->person->orderFamily($b);
				}else{
					return true;
				}
			})
			->query(function($q){
				$q->andClasses_id($this->xuId("classesid"));
				$q = $this->classification_finde_active_list($q);
				$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("name")->fieldFamily("family");
				$q->joinUsers()->whereId("#classification.users_id")->fieldUsername("username")->fieldId("usersid");
			})
			// ->search_result(function($result){
			// 	$vsearch = $_GET['search']['value'];
			// 	$vsearch = str_replace(" ", "_", $vsearch);
			// 	$result->condition("and", "##concat(person.name, person.family)", "LIKE", "%$vsearch%");
			// })
			->result(function($r){
				$r->input ="<div class='form-element' >" .  $this->tag("input")
									  ->type("text")
									  ->classificationid($r->input)
									  ->scoretypeid($this->xuId("scoretypeid"))
									  ->addClass('score-mark')
									  ->value($this->get_value($r->input, $this->xuId("scoretypeid")))
									  ->render() . "</div>";


				$r->more = $this->tag("a")->class("icomore")
				->tabindex(-1)->href("users/status=detail/id=". $r->more)->render();
			});
			$this->sql(".dataTable", $dtable);
	}

	public function get_value($classificationid = false, $scoretypeid = false) {
		$check = $this->sql()->tableScore()
					->whereClassification_id($classificationid)
					->andScore_type_id($scoretypeid)->limit(1)->select();
					// var_dump($check->assoc("value")); exit();
			return $check->assoc("value");
		if($check->num() == 1) {
		}else{
			return;
		}
	}
}
?>