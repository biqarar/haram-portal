<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
		public function post_api(){
		
		$dtable = $this->dtable->table("certification")
		->fields(
			"usersid learn",
			"username username",
			"name person.name",
			"family person.family",
			"planname",
			"mark",
			"date_request date_request",
			"date_print date_print",
			"date_deliver date_deliver"
		)
		->order(function($q, $n, $b){
			if($n === 'orderUsername'){
				$q->join->users->orderUsername($b);
			}else{
				return true;
			}
		})
		->search_fields(
			"username" , "name", "family", "date_request",
			"date_print",
			"date_deliver"
		)
		->query(function($q){
			$q->joinClassification()->whereId("#certification.classification_id")->fieldMark("mark");
			$q->joinClasses()->whereId("#classification.classes_id")->fieldId();
			$q->joinPlan()->whereId("#classes.plan_id")->fieldName("planname");
			$q->joinUsers()->whereId("#classification.users_id")->fieldUsername("username")->fieldId("usersid");
			$q->joinPerson()->whereUsers_id("#classification.users_id")->fieldFamily("family")->fieldName("name");
			// ilog($q->select()->string());
		})
		->result(function($r){
			// calendar
			if($r->date_print == null) {
				$r->date_print = $this->tag("a")->class("icocalendar")->render();
			}
			if($r->date_deliver == null) {
				$r->date_deliver = $this->tag("a")->class("icocalendar")->render();
			}
			// $r->edit = '<a class="icoedit" href="certification/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
			$r->learn = $this->tag("a")->href("users/learn/id=". $r->learn)->class("icoshare")->render();
			$r->username = $this->tag("a")->href("users/status=list?username=" . $r->username)
			->target("_blank")->vtext($r->username)->render();
			// // $r->absence = '<a class="icoattendance" href="classification/absence/certificationid='.$r->absence.'" title="'.gettext('absence').' '.$r->absence.'"></a>';
			// $r->detail = '<a class="icolearn" href="certification/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';

		});

		$this->sql(".dataTable", $dtable);
	}	
}
?>