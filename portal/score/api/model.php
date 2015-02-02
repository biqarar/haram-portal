<?php 
class model extends main_model {

	public function post_api(){


		$classificationid = $this->xuId("classificationid");
		$scoretypeid = $this->xuId("scoretypeid");
		$value = intval($this->xuId("value"));

		if($classificationid == 0 or $scoretypeid == 0 ) {
			debug_lib::fatal("خطا در اطلاعات");
		}

		$scoretype = $this->sql()->tableScore_type()->whereId($scoretypeid)->limit(1)->select()->assoc();

		if(intval($value) < intval($scoretype['min'])) {
			debug_lib::fatal("حد اقل امتیاز " . $scoretype['min']);
		}elseif(intval($value) > intval($scoretype['max'])) {
			debug_lib::fatal("حد اکثر امتیاز " . $scoretype['max']);
		}

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