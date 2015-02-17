<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="score";
		
		$classesid = $this->xuId("classesid");
		$score_type = $this->sql("#score_type", $classesid);
		
 		$list = array();

 		foreach ($score_type as $key => $value) {
 			
 			$title = "ثبت امتیاز " . $value['title'];
 			$list['list'][0][$title] = 
 				$this->tag("a")->href("score/classes/status=add/classesid=$classesid/scoretypeid=" . $value['id'])
 									->class("icodadd")->render();
 		}

 		if(!empty($list)) $list['list'][0]["نمایش کارنامه کلاس"] = 
 									$this->tag("a")
 										->href("score/classes/status=show/classesid=$classesid")
 									->class("icoscore")->render();

 		$this->data->a = $list;

		//------------------------------ get detail classes
		$this->classesDetail();
	}
}
?>