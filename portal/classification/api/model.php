<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function post_insert() {
		//------------------------------ set users id and classes id
		$users_id   = config_lib::$surl["usersid"];
		$classes_id = config_lib::$surl["classesid"];

		//------------------------------ check for duplicate
		$check = $this->sql()->tableClassification()->whereUsers_id($users_id)->andClasses_id($classes_id)->limit(1)->select();
		var_dump($check->num());
		if($check->num() ==0) {
			//------------------------------ insert classification
			$classification = $this->sql()->tableClassification()
					->setUsers_id($users_id)
					->setClasses_id($classes_id)
					->setDate_entry($this->dateNow())
					->insert();
					var_dump($classification->string());
		}else{
			debug_lib::fatal("نام این فراگیر در کلاس ثبت شده است");
		}	
	
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("اطلاعات فراگیر در کلاس ثبت شد");	
		});

		//------------------------------ rolback code
		$this->rollback(function() {
			debug_lib::fatal("ثبت اطلاعات با مشکل مواجه شده است");
		});
		exit();
	}
}
?>