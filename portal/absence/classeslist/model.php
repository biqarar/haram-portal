<?php
class model extends main_model {
	public function post_classeslist() {
		$dtable = $this->dtable->table("classification")
			
			->fields("name person.name", "family person.family","date_entry", "date_delete", "because","id insert", "usersid attendance")

			->search_fields("name person.name", "family person.family")
			
			->query(function($q){
				$q->andClasses_id($this->xuId("classesid"));
				$q->joinPerson()->whereUsers_id("#classification.users_id")
								->fieldName("name")->fieldFamily("family")->fieldUsers_id("usersid");

			})

			->search_result(function($result){
				$vsearch = $_GET['search']['value'];
				$vsearch = str_replace(" ", "_", $vsearch);
				$result->condition("and", "##concat(person.name, person.family)", "LIKE", "%$vsearch%");
			})

			->result(function($r){

				$r->attendance = $this->tag("a")
									  ->addClass("icoattendance")
									  ->href("absence/status=add/usersid=". $r->attendance)
									  ->render();

				$r->insert 	   = $this->tag("a")
									  ->addClass("icoadd a-undefault")
									  ->addClass("insertAbsenceApi")
									  ->classification($r->insert)
									  ->render();

			});

			$this->sql(".dataTable", $dtable);
	}
}
?>