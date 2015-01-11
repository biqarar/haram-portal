<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{


	public function config(){
		//------------------------------ global
		$this->global->page_title  = "teachers_list";
		$this->data->dataTable = $this->dtable(
			'teacher/status=api/',
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