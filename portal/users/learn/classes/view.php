<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		//------------------------------  global
		$this->global->page_title = _("پرونده تحصیلی") . " " . _("student");

		//------------------------------  set users_id
		$users_id  = $this->xuId();
		//------------------------------ check users (if teacher , can not be display another users by id)
		$this->check_users_type($users_id);

		$allClassification = $this->sql(".list", "classification", function ($query, $id) {
			$query->whereUsers_id($id);
			// $query->joinPlan()->whereId("#classes.plan_id")->fieldName("planname")->fieldId("planid");
			// $query->joinPlace()->whereId("#classes.place_id")->fieldName("placename")->fieldId("placeid");
			// $query->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teachername")->fieldFamily("teacherfamily");
			// var_dump($query->select();
		}, $users_id);
		// var_dump($allClassification);
		$this->data->list = $allClassification->compile();
	}
} 
?>