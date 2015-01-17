<?php 
class model extends main_model {

	public function post_api(){


		$classificationid = $this->xuId("classificationid");
		$scoretypeid = $this->xuId("scoretypeid");
		$value = $this->xuId("value");


		$check = $this->sql()->tableScore()
					->whereClassification_id($classificationid)
					->andScore_type_id($scoretypeid)->limit(1)->select()->num();
		
		
		if($check == 1) {
			$x = $this->sql()->tableScore()
							->whereClassification_id($classificationid)
							->andScore_type_id($scoretypeid)
							->setValue($value)
							->update();	

			$this->commit(function(){
				debug_lib::true("اطلاعات به روز رسانی شد");
			});
		}else{
			$x = $this->sql()->tableScore()
							->setClassification_id($classificationid)
							->setScore_type_id($scoretypeid)
							->setValue($value)
							->insert();	

			$this->commit(function(){
				debug_lib::true("اطلاعات ثبت شد");
			});
		}
	}
}
?>