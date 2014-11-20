<?php 
/**
* 
*/
class model extends main_model
{
	public function post_list() {
		
		$data = $this->sql(".dataTable", "person", function($q){
			// $q->field("name", "family", "father", "birthday", "gender", "nationalcode", "code", "nationalcode", "education_id");
		}, "name");
	}
}
 ?>