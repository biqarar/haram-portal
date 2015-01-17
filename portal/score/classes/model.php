<?php
class model extends main_model {

	public function sql_score_type($scoretypeid = false, $title = null) {
		if (!$scoretypeid) $scoretypeid = $this->xuId("scoretypeid");
		return $this->sql()->tableScore_type()->whereId($scoretypeid)->limit(1)->select()->assoc($title);
	}
	public function post_api() {

		$score_type = $this->sql_score_type();


		$array = array("name person.name", "family person.family","id input", "id insert", "id edit");
		
		
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
				$r->input = $this->tag("input")
									  ->classificationid($r->input)
									  ->scoretypeid($this->xuId("scoretypeid"))
									  ->addClass('score-mark')
									  // ->href("absence/status=add/usersid=". $r->input)
									  ->render();

				$r->insert 	   = $this->tag("a")
				 						->style("cursor: pointer;")
									  ->addClass("icodadd a-undefault")
									  ->addClass("insertAbsenceApi")
									  ->classification($r->insert)
									  ->tabindex("-1")
									  ->render();

				$r->edit = $this->tag("a")->addClass("icoedit")->href("classification/status=edit/id=". $r->edit)->tabindex("-1")->render();
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>