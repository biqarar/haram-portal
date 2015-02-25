<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		//------------------------------  global
		$this->global->page_title = "certification";

		$this->data->users_name_family = $this->sql(".userNameFamily", $users_id);
		$this->data->title = "گواهی نامه های ثبت شده برای فراگیر";
		// $this->data->description = "کلاس های شرکت کرده، غیبت ها، نمرات و گواهی نامه";
		
		$certification = $this->sql(".list", "certification", function ($query) {
			$query->joinClassification()->whereId("#certification.classification_id")
			->andUsers_id($this->xuId("usersid"))
			->fieldMark();
			$query->joinClasses()->whereId("#classification.classes_id")->fieldId();
			$query->joinPlan()->whereId("#classes.plan_id")->fieldName();
		});
		$certification->removeCol("classification_id");
		$certification->addColFirst("mark", "mark");
		$certification->addColFirst("name","name");
		$certification->addColFirst("id", "id");
		$this->data->list = $certification->compile();

	}
} 
?>