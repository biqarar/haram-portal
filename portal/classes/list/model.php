<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
public $assoc = array();

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
			"planname planname",
			"teachername",
			"teacherfamily",
			"placename",
			"age_range",
			"start_time",
			"end_time",
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
			// $q->joinCourseclasses()->whereClasses_id("#classes.id");
			// $q->joinCourse()->whereId("#courseclasses.course_id")->fieldName("coursename");
			$q->joinPerson()->whereUsers_id("#classes.teacher")->fieldFamily("teacherfamily")->fieldName("teachername");
			$q->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
			// $this->assoc = $q->select()->allAssoc();
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
			$r->planname = $this->courseclasses_information($r->planname, $r->detail);
			$r->detail = '<a class="icomore" href="classes/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';


		}, $ico , $url);

		$this->sql(".dataTable", $dtable);
		// var_dump($this->assoc);exit();
	}	

	function courseclasses_information($planname = false, $classesid = false) {
		$courseclasses = $this->sql()->tableCourseclasses()->whereClasses_id($classesid);
		$courseclasses->joinCourse()->whereId("#courseclasses.course_id")->fieldName("coursename");
		$courseclasses = $courseclasses->limit(1)->select();
		if($courseclasses->num() == 1) {
			$title = "ثبت شده در دوره \n ";
			return  $planname .' <a class="courseclasses-information" title="'.$title. $courseclasses->assoc("coursename"). '"></a>';
		}else{
			return $planname;
		}
	}

}
?>