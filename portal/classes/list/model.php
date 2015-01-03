<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
		public function post_api(){
		
		$type = $this->xuId("type");
		$url = "classification/class/";
		$ico = "icoclass";
		if($type != "classification" && $type != "absence") {
			$url = "classification/class/";
			$ico = "icoclass";
		}elseif($type == "absence"){
			$url = "absence/classes/";
			$ico = "icoattendance";
		}


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
			"maxp plan.max_person",
			"count",
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
			}elseif($n === 'orderMaxp'){
				$q->join->plan->orderMax_person($b);
			}else{
				return true;
			}
		})
		->query(function($q){
			$q->joinPlan()->whereId("#classes.plan_id")->fieldName('planname')->fieldMax_person("maxp");
			$q->joinPerson()->whereUsers_id("#classes.teacher")->fieldFamily("teacherfamily")->fieldName("teachername");
			$q->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
		})
		->result(function($r, $ico, $url){
			$r->classification = '<a class="'. $ico . '" href="'.$url.'classesid='.$r->classification.'" title="'.gettext('classification').' '.$r->classification.'"></a>';
			$r->detail = '<a class="icomore" href="classes/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';
		}, $ico , $url);

		$this->sql(".dataTable", $dtable);
	}	
}
?>