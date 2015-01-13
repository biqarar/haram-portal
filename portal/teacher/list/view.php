<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		//------------------------------ global
		$type = ($this->xuId("type") == "teacher") ? "teachers" : "operator";
		$this->global->page_title  = " لیست " . _($type);
		$this->data->dataTable = $this->dtable(
			'teacher/status=apilist/type=' . $this->xuId("type") . "/",
			array(
				'casecode',
				'name',
				'family',
				'father',
				'birthday',
				'gender',
				'nationalcode',
				'code',
				// 'marriage',
				// 'education_id',
				'detail',
				'person_extera')
			);
	
	}
}
?>