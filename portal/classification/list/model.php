<?php
class model extends main_model {
	public function post_api() {
		$dtable = $this->dtable->table("classification")
			->fields("name person.name", "family person.family","date_entry", "date_delete", "because", "id edit")
			->search_fields("name person.name", "family person.family")
			->query(function($q){
				$q->groupOpen()->andClasses_id($this->xuId("classesid"))->groupClose();
				$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldName("name")->fieldFamily("family");

			})
			->result(function($r){
				$r->edit = $this->tag("a")->addClass("icoedit")->href("classification/status=edit/id=". $r->edit)->render();
			});
			$this->sql(".dataTable", $dtable);
	}
}
?>