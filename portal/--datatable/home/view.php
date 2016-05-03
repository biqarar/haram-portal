<?php
class view extends main_view{
	public function config(){
		$list = $this->sql(".list", 'person', function($arg){
			$arg
			->foreignEducation_id();
		})
		->removeCol("education_id");
		$this->data->list = $list->compile();
	}
}