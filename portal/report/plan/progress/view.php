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
		$this->data->plan_detail = $this->sql(".assoc.foreign" , "plan", $plan_id , "name" , "id");

		//------------------------------ get detail classes
		// $this->classesDetail();
		$chart = $this->sql("#progress", $plan_id);
		$this->data->chart = $chart;

		$absence = $this->sql("#absence", $plan_id);
		$this->data->absence = $absence;

		$list = $this->sql(".list", "classification", function($q){
			$q->fieldDate_entry()->fieldDate_delete();
			$q->joinClasses()->whereId("#classification.classes_id")->andStatus("running")->field("id");
			$q->joinPerson()->whereUsers_id("#classification.users_id")
			->fieldName()
			->fieldFamily()
			->fieldFather();
			$q->joinPlan()->whereId("#classes.plan_id")->andId($this->xuId("id"))->fieldId();
			$q->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue();
			$q->whereBecause("absence");

		})->compile();
		$this->data->list = $list;
	}
}
?>