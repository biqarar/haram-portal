<?php
class query_classesCount_cls extends query_cls
{
	public function config($classes_id = false){
		$update = $this->sql()
			->tableClasses()
			->setCount($this->count($classes_id))
			->whereId($classes_id)->update();
	}


	public function count($classes_id = false) {
	//------------------------------- set classification count in to classes table
		$count = $this->sql()->tableClassification()->whereClasses_id($classes_id);
		return $this->classification_finde_active_list($count)->select()->num();

	}
}
?>