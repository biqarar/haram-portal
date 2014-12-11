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
			$classes_list[$key]['name'] = $this->sql(".assoc.foreign", "person", $value['users_id'], "name" , "users_id");
			$classes_list[$key]['family'] = $this->sql(".assoc.foreign", "person", $value['users_id'], "family" , "users_id");
			$classes_list[$key]['phone'] = $this->sql(".assoc.foreign", "bridge", $value['users_id'], "value" , "users_id" , "title=phone");
			$classes_list[$key]['mobile'] = $this->sql(".assoc.foreign", "bridge", $value['users_id'], "value" , "users_id" , "title=mobile");
		}

		//------------------------------ list of classes
		$classes_detail = $this->sql(".list", "classes", function ($query) {
			$query->whereId($this->xuId("classesid"));
		})->compile();

		//------------------------------ convert paln_id , teacher , place id , ... to name of this
		$classes_detail = $this->detailClasses($classes_detail);
		

		// var_dump($classes_detail , $classes_list);
		$this->data->detail = $classes_detail;
		$this->data->list = $classes_list;
	}
}
?>