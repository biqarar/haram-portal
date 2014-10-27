<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function post_insert() {
		$users_id = config_lib::$aurl[2];
		$classes_id = config_lib::$aurl[3];
		$check = $this->sql()->tableClassification()->whereUsers_id($users_id)->andClasses_id($classes_id)->limit(1)->select();
		

		if($check->num() ==0) {
			$classification = $this->sql()->tableClassification()
					->setUsers_id($users_id)
					->setClasses_id($classes_id)
					->setDate_entry($this->dateNow())
					->insert();//->LAST_INSERT_ID();
			
		}		
					// var_dump($classification->string());
					// exit();
		$this->commit(function() {
			debug_lib::true("اطلاعات فراگیر در کلاس ثبت شد");	
		});
		$this->rollback(function() {
			debug_lib::fatal("ثبت اطلاعات با مشکل مواجه شده است");
		});
		exit();
	}
}
?>