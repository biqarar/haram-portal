<?php 
/**
* 
*/
class model extends main_model {

	public $type = false;
	
	function post_api()	{

		$classification = $this->xuId("classification");
		
		$date = $this->xuId("date");
		$type = $this->xuId("type");
		
		$check = $this->sql()->tableAbsence()->whereClassification_id($classification)->andDate($date)->limit(1)->select()->num();

		if($check != 0) {
			debug_lib::fatal("برای این فراگیر در این تاریخ ثیبت ثبت شده است");
		}else{
			//--------------- check if this classification id in the users branch or no.
			$this->sql(".branch.classification", $classification);

			$x = $this->sql()->tableAbsence()
						->setClassification_id($classification)
						->setType($type)
						->setDate($date)
						->insert();

			$this->type = $type;
			
		}

		$this->commit(function(){
			debug_lib::true(_($this->type) .  " ثبت شد");
		});

		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت اطلاعات");
		});
	
	}

	public function post_delete(){
		$classification = $this->xuId("classification");
		$date = $this->xuId("date");

		$check = $this->sql()->tableAbsence()->whereClassification_id($classification)->andDate($date);

		if($check->select()->num() == 0) {
			debug_lib::fatal("هیچ گونه غیبت برای این فراگیر در این تاریخ ثبت نشده است");
		}

		$this->type = $check->select()->assoc("type");

		$x = $check->delete();
	
		$this->commit(function(){
			debug_lib::true(_($this->type) .  " حذف شد");
		});

		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت اطلاعات");
		});
	}
}

?>