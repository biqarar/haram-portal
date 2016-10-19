<?php 
/**
* 
*/
class model extends main_model {

	public function post_api() {

		$dtable = $this->dtable->table("absence")
		->fields("planname","classesid classesid", "teacherfamily", 'date date', 'type',"because", "id edit" , "classificationid delete")
		->search_fields("date", "classes_id")
		
		->query(function($q){
			//-------------------- check branch
			$this->sql(".branch.users",$this->xuId("usersid"));
			if($this->xuId("classesid") != "0")
			{
				
				$q->joinClassification()
					->whereId("#absence.classification_id")
					->andUsers_id($this->xuId("usersid"))
					->andClasses_id($this->xuId("classesid"))
					->fieldClasses_id("classesid")
					->fieldId("classificationid");
			}
			else
			{

				$q->joinClassification()
					->whereId("#absence.classification_id")
					->andUsers_id($this->xuId("usersid"))
					->fieldClasses_id("classesid")
					->fieldId("classificationid");
			}

			$q->joinClasses()->whereId("#classification.classes_id")->fieldId("classes_id")->fieldPlan_id("plan_id");
			$q->joinPlan()->whereId("#classes.plan_id")->fieldName("planname");
			$q->joinPerson()->whereUsers_id("#classes.teacher")->fieldFamily("teacherfamily");

		})
		->order(function($q, $n, $b){
			if($n === 'orderTeacherfamily'){
				$q->join->person->orderFamily($b);
			}elseif($n === 'orderPlanname'){
				$q->join->plan->orderName($b);
			}elseif($n === 'orderClasses_id'){
				$q->join->classes->orderId($b);
			}else{
				return true;
			}
		})
		->result(function($r) {
			$r->edit = '<a class="icoedit" href="absence/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
			$r->delete = $this->tag("a")->class("icoredclose absenceDelete")->date($r->date)
			->classificationid($r->delete)->render();
			$r->classesid = $this->tag("a")->vtext($r->classesid)->style("color:blue;")->title("برای نمایش تمامی غیبت های فراگیر در این کلاس کلیک کنید")
			->href("users/learn/absence/id=". $this->xuId("usersid")."/classesid=". $r->classesid)->render();
		});
		$this->sql(".dataTable", $dtable);

	}
	public function sql_classification_list($usersid = false) {
		$return = array();
		$return['sum_active'] = 0;
		$return['sum_all'] = 0;
		$return['classes'] = array();
		$sql = $this->sql()->tableClassification()->whereUsers_id($usersid);
		$sql->joinClasses()->whereId("#classification.classes_id");
		$sql->joinPlan()->whereId("#classes.plan_id")->fieldName("planname");
		$sql->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
		$sql->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teachername")->fieldFamily("teacherfamily");
		$x = $sql->select()->allAssoc();
		
		foreach ($x as $key => $value) {

			$return['sum_all']++;
			// if(empty($x[$key]['date_delete']) || $x[$key]['date_delete'] == ''){
				$return['sum_active']++;

				$return['classes'][$key]['string'] = $x[$key]['planname'] 		. '  ' .
								   _($x[$key]["age_range"]) 		. '  ' . 
								   $x[$key]['placename'] 		. ' ساعت ' .
								   $x[$key]['end_time']			. ' استاد ' .
								   $x[$key]["teachername"] 		. '  ' . 
								   $x[$key]['teacherfamily'];
				$return['classes'][$key]['id'] = $x[$key]["classes_id"];
				// }
								   
		}
		return $return;
	}
}
?>