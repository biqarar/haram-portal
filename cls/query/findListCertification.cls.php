<?php 
class query_findListCertification_cls extends query_cls {

	private $classification_id = false;

	public function config($usersid = false) {
		$certification = $this->sql()->tableClassification();
		if($this->classification_id) {
			$certification->whereId($this->classification_id);
		}else{
			$certification->whereUsers_id($usersid);
		}
		$certification->condition("and", "certification.classification_id", "IS", "NULL")
			->fieldId()->fieldMark();
		$certification->joinClasses()->whereId("#classification.classes_id")->fieldId("classesid");
		$certification->joinPlan()->whereId("#classes.plan_id")
			->condition("and", "##classification.mark", ">=" , "#plan.mark")
			->fieldName("planname")->fieldId("planid");
		$certification->joinCertification("LEFT OUTER")
			->whereClassification_id("=" , "#classification.id");

		$ready = $certification->select()->allAssoc();

		$duplicate = $this->sql()->tableCertification();
		$duplicate->joinClassification()->whereId("#certification.classification_id");
		$duplicate->joinClasses()->whereId("#classification.classes_id");
		$q = $duplicate->joinPlan()->whereId("#classes.plan_id");
		foreach ($ready as $key => $value) {
			$q->andId("=", $value['planid']);
		}
		
		$duplicate = $duplicate->select()->num();

		return ($duplicate == 0) ? $ready : array();
		
	}

	function classes($classification_id = false) {
		$this->classification_id = $classification_id;
		return $this->config();
	}
}
?>
