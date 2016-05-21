<?php
class query_classes_cls extends query_cls
{
	
	public function detail($classes_id = false) {
		//---------------- check branch
		$this->sql(".branch.classes", $classes_id);
		
		return $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assco();
	}

	public function count($classes_id = false){
		///------------------- check branch
		// $this->sql(".branch.classes", $classes_id);

		$count = $this->sql()->tableClassification()->whereClasses_id($classes_id);
		$classes_count = $this->classification_finde_active_list($count)->select()->num();

		$min_person = $this->sql()->tableClasses()->whereId($classes_id)->andStatus("ready");
		$min_person->joinPlan()->whereId("#classes.plan_id")->fieldMin_person();
		$min_person = $min_person->select()->assoc("min_person");
		
		$update = $this->sql()
			->tableClasses()
			->setCount($classes_count)
			->whereId($classes_id);
		
		if($min_person < $classes_count) {
			$update->setStatus("running");
		}
			$update->update();
	}


}
?>