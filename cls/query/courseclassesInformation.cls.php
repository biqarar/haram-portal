<?php 
class query_courseclassesInformation_cls extends query_cls {
	function config($planname = false, $classesid = false) {
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