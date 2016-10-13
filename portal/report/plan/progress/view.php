<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		//------------------------------  global
		$this->global->page_title = _("وضعیت نمرات کلاس");

		//------------------------------  set users_id
		$users_id  = $this->xuId();

			//----------------------- check banch

		$plan_id = $this->xuId("id");
		$this->sql(".branch.plan",$plan_id);
		//------------------------------ get detail classes
		// $this->classesDetail();
		$chart = $this->sql("#progress", $plan_id);
		$this->data->chart = $chart;
	}
} 
?>