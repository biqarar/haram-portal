<?php 
class model extends main_model {

	public function post_api(){
		debug_lib::true("fuck");
		
		$classificationid = $this->xuId("classificationid");
		$scoretypeid = $this->xuId("scoretypeid");
		$value = $this->xuId("value");

		$sql = $this->sql()->tableScore()->whereClassification_id($classificationid)->andScore_type_id($scoretypeid);
		
		$check = $sql;
		if($check->limit(1)->select()->num() == 1) {
			$sql->setValue($value)->update();	
			$this->commit(function(){
				debug_lib::true("اطلاعات ثبت شد");
			});
		}else{
			$sql->setValue($value)->insert();
			$this->commit(function(){
				debug_lib::true("اطلاعات بهروز رسانی شد");
			});
		}
	}
}
?>