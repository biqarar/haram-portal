<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
		public function post_api(){
		$type = $this->xuId("type");
		
		switch ($type) {

			case 'classification':
			case '':
				$url = "classification/class/";
				$ico = "icoclass";
				break;

			case 'absence':
				$url = "absence/classes/";
				$ico = "icoattendance";
				break;

				
			case 'score':
				$url = "score/classes/";
				$ico = "icoscore";
				break;

			case 'price':
				$url = "price/classes/";
				$ico = "icoprice";
				break;

			case 'courseclasses':
				$url = "courseclasses/apiadd/";
				$ico = "icodadd";
				break;

			case 'presence':
				$url = "presence/";
				$ico = "icodattendance";
				break;


			default:
				$url = "classification/class/";
				$ico = "icoclass";
				break;
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
			//"week_days",
			"name",
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
			}elseif($n === 'orderCount'){
				$q->orderCount($b);
			}elseif($n === 'orderStart_time'){
				$q->orderStart_time($b);
			}elseif($n === 'orderEnd_time'){
				$q->orderEnd_time($b);
			}elseif($n === 'orderName'){
				$q->orderName($b);
			}else{
				$q->orderId("DESC");	
			}
		})
		->query(function($q){
			$q->joinPlan()->whereId("#classes.plan_id")->fieldName('planname')->fieldMax_person("maxp");
			$q->joinPerson()->whereUsers_id("#classes.teacher")->fieldFamily("teacherfamily")->fieldName("teachername");
			$q->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
		})
		->result(function($r, $ico, $url){
			if($ico == "icodadd") {
				$r->classification = $this->tag("a")
											->class("icodadd courseclasses-apiadd")
											->id($r->classification)
											->style("cursor:pointer")
											->render();
			}else{
				$r->classification = '<a class="'. $ico . '" href="'.$url.'classesid='.$r->classification.'" title="'.gettext('classification').' '.$r->classification.'"></a>';
			}
			$r->detail = '<a class="icomore" href="classes/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';


		}, $ico , $url);

		$this->sql(".dataTable", $dtable);
	}	

}
?>