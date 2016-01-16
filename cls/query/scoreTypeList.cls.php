<?php 
/**
* 
*/
class query_scoreTypeList_cls extends query_cls {

	public function config($classesid = false) {
		$score_type = $this->score_type($classesid);
		foreach ($score_type as $key => $value) {
			// var_dump($value['id']);exit();
 			
 			$title = "ثبت امتیاز " . $value['title'];
 			$list['list'][0][$title] = 
 				"<a href='score/classes/status=add/classesid=$classesid/scoretypeid=" 
 				. $value['id'] . "' class='icodadd'></a>";
 		}

 		if(!empty($list)) $list['list'][0]["نمایش کارنامه کلاس"] = 
 			"<a href='score/classes/status=show/classesid=$classesid' class='icoscore'></a>";
		return $list;
	}

	public function score_type($classesid = false) {
		$plan_id = $this->sql()->tableClasses()->whereId($classesid)->limit(1)->fieldPlan_id()->select()->assoc("plan_id");
		$score_type = $this->sql()->tableScore_type()->wherePlan_id($plan_id)->select()->allAssoc();
		// var_dump($score_type,$classesid);exit();	
		return $score_type;
	}
}

?>
