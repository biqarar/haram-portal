<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function post_insert() {
		//------------------------------ set users id and classes id
		$users_id   = config_lib::$surl["usersid"];
		$classes_id = config_lib::$surl["classesid"];

		//------------------------------ key for check duplicate
		$duplicate = false;

		//------------------------------ check for duplicate
		$check = $this->sql()->tableClassification()->whereUsers_id($users_id)->andClasses_id($classes_id)->limit(1)->select();
		if($check->num() ==0) {
			//------------------------------ insert classification
			$classification = $this->sql()->tableClassification()
					->setUsers_id($users_id)
					->setClasses_id($classes_id)
					->setDate_entry($this->dateNow())
					->insert();
		}else{

			$duplicate = true;
			debug_lib::msg("duplicate", "اطلاعات تکراری است");
		}	
	
		//------------------------------ commit code
		if(!$duplicate) {
			$this->commit(function() {
				debug_lib::msg("insert","اطلاعات ثبت شد");	
			});
		}

		//------------------------------ rolback code
		$this->rollback(function() {
			debug_lib::msg("failed","خطا در ثبت");
		});
	}
}
?>