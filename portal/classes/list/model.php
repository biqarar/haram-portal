<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
		public function post_api(){
		
		$dtable = $this->dtable->table("classes")
		->fields(
			"id",
			"planname",
			"teachername",
			"teacherfamily",
			"placename",
			"age_range",
			"start_time",
			"end_time",
			"max capacity",
			"id classification",
			"id detail")
		
		
		->search_fields(
			"id classes.id",
			"planname plan.name" ,
			"teachername person.name",
			"teacherfamily person.family",
			"placename place.name",
			// "meeting_no classes.meeting_no",
			// "age_range classes.age_range",
			// "start_time classes.start_time",
			// "end_time classes.end_time",
			// "start_date classes.start_date",
			// "end_date classes.end_date",
			// "week_days classes.week_days",
			"name classes.name")
		->order(function($q, $n, $b){
			if($n === 'orderPlanname'){
				$q->join->plan->orderName($b);
			}elseif($n === 'orderTeacherfamily'){
				$q->join->person->orderFamily($b);
			}elseif($n === 'orderTeachername'){
				$q->join->person->orderName($b);
			}elseif($n === 'orderPlacename'){
				$q->join->place->orderName($b);
			}else{
				return true;
			}
		})
		->query(function($q){
			$q->joinPlan()->whereId("#classes.plan_id")->fieldName('planname')->fieldMax_person("max");
			$q->joinPerson()->whereUsers_id("#classes.teacher")->fieldFamily("teacherfamily")->fieldName("teachername");
			$q->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
			// $q->joinClassification()->whereClasses_id("#classes.id")->fieldId("sum");
			// var_dump($q);
			// exit();
		})
		->result(function($r){
			// $r->edit = '<a class="icoedit" href="classes/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
			$r->classification = '<a class="icoclasses" href="classification/class/classesid='.$r->classification.'" title="'.gettext('classification').' '.$r->classification.'"></a>';
			// $r->absence = '<a class="icoattendance" href="classification/absence/classesid='.$r->absence.'" title="'.gettext('absence').' '.$r->absence.'"></a>';
			$r->detail = '<a class="icomore" href="classes/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';

		});

		$this->sql(".dataTable", $dtable);
	}	
}
?>