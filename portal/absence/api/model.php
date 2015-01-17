<?php 
/**
* 
*/
class model extends main_model {
	
	function post_api()	{
		$classification = $this->xuId("classification");
		$date = $this->xuId("date");
		$type = $this->xuId("type");
		
		$check = $this->sql()->tableAbsence()->whereClassification_id($classification)->andDate($date)->limit(1)->select()->num();

		if($check != 0) {
			debug_lib::fatal("برای این فراگیر در این تاریخ ثیبت ثبت شده است");
		}

		$x = $this->sql()->tableAbsence()
					->setClassification_id($classification)
					->setType($type)
					->setDate($date)
					->insert();

		$this->commit(function(){
			debug_lib::true("غیبت ثبت شد");
		});

		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت اطلاعات");
		});
		// var_dump($x->string(), $x->result());
		// exit();
	
	}

	public function post_delete(){
		$classification = $this->xuId("classification");
		$date = $this->xuId("date");

		$check = $this->sql()->tableAbsence()->whereClassification_id($classification)->andDate($date);

		// if($check->limit(1)->select()->num() == 0) {
		// 	debug_lib::fatal("هیچ گونه غیبت برای این فراگیر در این تاریخ ثبت نشده است");
		// }

		$x = $check->delete();
		ilog($x->string());
		$this->commit(function(){
			debug_lib::true("غیبت حذف شد");
		});

		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت اطلاعات");
		});

	
		// var_dump($x->string(), $x->result());
		// exit();
	}
}

?>