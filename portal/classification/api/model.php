<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function post_insert() {
		
		//------------------------------ set users id and classes id
		$users_id   = config_lib::$surl["usersid"];
		$classes_id = config_lib::$surl["classesid"];
		// $name_famil 
		//------------------------------ key for check duplicate
		$duplicate = false;
		//------------------------------ check for duplicate this classes inserted 
		$check = $this->sql()->tableClassification()->whereUsers_id($users_id)->andClasses_id($classes_id)->limit(1)->select();
		
		if($check->num() == 0) {
			//------------------------------ check duplicate other classes as time for this users
			list($duplicate, $msg) = $this->sql(".duplicateUsersClasses.classification", $users_id, $classes_id);
			if($duplicate) {
				debug_lib::fatal("اطلاعات این کلاس با کلاس شماره" . $msg . " که برای این کاربر ثبت شده است تداخل دارد ");
			}else{
				//------------------------------ check price 
				if(!$this->sql(".price.checkClasses", $users_id , $classes_id)) {
	
					debug_lib::fatal("شهریه کافی نیست لفطا نسبت به شارژ حساب این فراگیر اقدام فرمایید.");
			
				}elseif(!$this->sql(".pasportCheck", $users_id)){
				
					debug_lib::fatal("اعتبار گذرنامه این فراگیر به اتمام رسیده است");
				
				}else{
					//------------------------------ insert classification
					$classification = $this->sql()->tableClassification()
							->setUsers_id($users_id)
							->setClasses_id($classes_id)
							->setDate_entry($this->dateNow())
							->insert();
					//------------------------------- set classification count in to classes table
					$this->sql(".classesCount", $classes_id);
				}
			}
		}else{

			$duplicate = true;
			debug_lib::fatal("این فراگیر قبلا در کلاس ثبت شده است");
		}	
	
		//------------------------------ commit code
		if(!$duplicate) {
			$this->commit(function() {
				debug_lib::true("فراگیر به کلاس اضافه شد");	
			});
		}

		//------------------------------ rolback code
		$this->rollback(function() {
			debug_lib::fatal("خطا در ثبت");
		});
	}
}
?>