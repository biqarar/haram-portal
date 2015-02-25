<?php
class model extends main_model {

	public function post_api() {

		$array = array("name person.name", "family person.family","id input");
		
		$dtable = $this->dtable->table("classification")
			->fields($array)
			->search_fields("name person.name", "family person.family")
			->query(function($q){
				$q->andClasses_id($this->xuId("classesid"));

				$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("name")->fieldFamily("family");

			})
			->search_result(function($result){
				$vsearch = $_GET['search']['value'];
				$vsearch = str_replace(" ", "_", $vsearch);
				$result->condition("and", "##concat(person.name, person.family)", "LIKE", "%$vsearch%");
			})
			->result(function($r){
				$r->input ="<div class='form-element' >" .  $this->tag("input")
									  ->type("text")
									  ->classificationid($r->input)
									  ->scoretypeid($this->xuId("scoretypeid"))
									  ->addClass('score-mark')
									  ->value($this->get_value($r->input, $this->xuId("scoretypeid")))
									  ->render() . "</div>";


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