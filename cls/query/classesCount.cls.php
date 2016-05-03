<?php
class query_classesCount_cls extends query_cls
{
	public function config($classes_id = false){
		///------------------- check branch
		$this->sql(".branch.classes", $classes_id);

		$classes_count = $this->count($classes_id);
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


	public function count($classes_id = false) {
	//------------------------------- set classification count in to classes table
		$count = $this->sql()->tableClassification()->whereClasses_id($classes_id);
		return $this->classification_finde_active_list($count)->select()->num();

	}
}
?>