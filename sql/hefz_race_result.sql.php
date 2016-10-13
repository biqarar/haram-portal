<?php
/**
* @author reza mohiti
*/
namespace sql;
class hefz_race_result {

	public $id = array("type" => "int@10", "lable"=> "hefz_race_result_id");
	public $hefz_race_id = array("type" => "int@10", "lable"=> "hefz_race_result_hefz_race_id");
	public $hefz_teamuser_id = array("type" => "int@10", "lable"=> "hefz_race_result_hefz_teamuser_id");
	public $type = array("type" => "varchar@64", "lable"=> "hefz_race_result_type");
	public $value = array("type" => "float@", "lable"=> "hefz_race_result_value");

	public function id() {
		$this->validate("id");
	}
	
	public function hefz_race_id() {
		$this->validate("id");

	}
	
	public function hefz_teamuser_id() {
		$this->validate("id");

	}
	
	
	public function type() {

	}
	
	public function value() {

	}
	
}

?>