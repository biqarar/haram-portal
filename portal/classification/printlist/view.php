<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {
		//------------------------------ get classes list
		$classes_list = $this->sql("#classes_list", $this->xuId("classesid"));

		//------------------------------ add name, family, phone, mobile to classes array
		foreach ($classes_list as $key => $value) {
			$classes_list[$key]['phone'] = $this->sql(".assoc.foreign", "bridge", $value['users_id'], "value" , "users_id" , "title=phone");
			$classes_list[$key]['mobile'] = $this->sql(".assoc.foreign", "bridge", $value['users_id'], "value" , "users_id" , "title=mobile");
		}

		//------------------------------ list of classes
		$classes_detail = $this->sql(".list", "classes", function ($query) {
			$query->whereId($this->xuId("classesid"));
		})->compile();

		$plan_id = $classes_detail['list'][0]['plan_id'];

		//------------------------------ convert plan_id , teacher , place id , ... to name of this
		if(isset($classes_detail['list'])){	
			foreach ($classes_detail ['list'] as $key => $value) {
				$classes_detail ['list'][$key]['plan_id']   = $this->sql(".assoc.foreign", "plan", $value["plan_id"], "name");
				$classes_detail ['list'][$key]['teacher']   = 
				$this->sql(".assoc.foreign", "person", $value["teacher"], "name", "users_id") . ' ' . 
				$this->sql(".assoc.foreign", "person", $value["teacher"], "family", "users_id");
				$classes_detail ['list'][$key]['place_id']  = $this->sql(".assoc.foreign", "place", $value["place_id"], "name");
			}	
		}

		$this->data->classesid = $this->xuId("classesid");
		$this->data->type = $this->xuId("type");
		// var_dump($classes_detail , $classes_list); exit();
		$score_type = $this->sql("#score_type", $plan_id);
		// var_dump($score_type);
		$this->data->score_type = $score_type; 
		$this->data->detail = $classes_detail;
		$this->data->list = $classes_list;
	}
}
?>