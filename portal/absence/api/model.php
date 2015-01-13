<?php 
/**
* 
*/
class model extends main_model {
	
	function post_api()	{
		$classification = $this->xuId("classification");
		$date = $this->xuId("date");
		
		$check = $this->sql()->tableAbsence()->whereClassification_id($classification)->andDate($date)->limit(1)->select()->num();

		if($check != 0) {
			debug_lib::fatal("برای این فراگیر در این تاریخ ثیبت ثبت شده است");
		}

		$this->sql()->tableAbsence()
					->setClassification_id($classification)
					->setType("unjustified absence")
					->setDate($date)
					->insert();

		$this->commit(function(){
			debug_lib::true("غیبت ثبت شد");
		});

		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت اطلاعات");
		});
	
	}
}

?>