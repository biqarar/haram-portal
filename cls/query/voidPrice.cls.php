<?php
class query_voidPrice_cls extends query_cls
{
	public function classes($classesid = false){
		$classification = $this->sql()->tableClassification()->whereClasses_id($classesid)
			->groupOpen()
			->condition("and", "#date_delete" , "is", "#null")
			->condition("or", "#because", "is", "#null")
			->groupClose();

		$classification->joinPrice()->whereUsers_id("#classification.users_id")
			->andPay_type("rule")
			->andStatus("active")
			->andTitle(5)
			->andTransactions($classesid)->fieldId("priceid");
		$classification = $classification->select()->allAssoc();
		foreach ($classification as $key => $value) {
			$this->sql()->tablePrice()->whereId($value['priceid'])->setStatus("void")->update();
		}
	}
}
?>