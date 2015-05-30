<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public $classification_id = array();

	public function post_apiclasses() {
		$classesid = $this->xuId("classesid");
		if(!$this->sql_startpresence($classesid)){
			$t=time();
			$time = date("H:i:s",$t);
			$set = $this->sql()->tablePresence_classes()->setClasses_id($classesid)->setDate($this->dateNow())->setStart_time("#'" .  $time .  "'")->insert();
			$this->insert_absence_all($classesid);
			debug_lib::true("عملیات ثبت حضرو فعال شد");
		}else{
			debug_lib::fatal("فرایند ثبت حضور این کلاس در حال اجرا یا به پایان رسیده است");
		}
	}

	function insert_absence_all($classesid = false){
		
		$classes_list = $this->sql()->tableClassification()->whereClasses_id($classesid);
		$classes_list = $this->classification_finde_active_list($classes_list);

		$classes_list= $classes_list->select()->allAssoc();

		foreach ($classes_list as $key => $value) {
			$insert_absence_all = $this->sql()->tablePresence()
				->setClassification_id($value['id'])
				->setDate($this->dateNow())
				->setStatus("absence")
				->insert();
		}
	}

	public function sql_startpresence($classesid = false) {
		$check = $this->sql()->tablePresence_classes()->whereClasses_id($classesid)->limit(1)->select()->num();
		if($check == 1) {
			return true;
		}else{
			return false;
		}
	}

	function post_apiadd() {
		$data = $this->xuId("username");
		$classesid = $this->xuId("classesid");

		$users_id = $this->find_users_id($data);
		
		$check_classes = $this->check_classes($users_id, $classesid);

		if($check_classes) {
			if($this->insert_presence()){
				debug_lib::true("ثتب حضور فراگیر " . $this->classification_id["name"] . " " . $this->classification_id['family']  .  " انجام شد");
			}else{
				debug_lib::fatal("ثبت حضور با مشکل واحه شده است");
			}
		}else{
			debug_lib::fatal(" نام این فراگیر در این کلاس ثبت نشده است");
		}


	}

	function find_users_id($username = false){
		if($this->nationalcode($username)){
			$users_id = $this->sql()->tablePerson()
				->whereNationalcode($username)
				->fieldUsers_id()->select();
			
			if($users_id->num() == 1){
				return $users_id->assoc("users_id");
			}else{
				debug_lib::fatal("nationalcode not found");
			}

		}else{
			$users_id = $this->sql()->tableUsers()
				->whereUsername($username)
				->fieldId()->select();
			
			if($users_id->num() == 1){
				return $users_id->assoc("id");
			}else{
				return 0;
			}
		}
	}

	function check_classes($users_id = false, $classesid = false){
		$check = $this->sql()->tableClassification()
			->whereUsers_id($users_id)
			->andClasses_id($classesid);
		$check = $this->classification_finde_active_list($check);
		$check->joinPerson()->whereUsers_id("#classification.users_id")->fieldName()->fieldFamily();
		$check = $check->select();

		if($check->num() == 1){
			$this->classification_id = $check->assoc();
			return true;
		}else{
			return false;
		}	
	}



	function insert_presence(){
		$insert_presence = $this->sql()->tablePresence()
			->whereClassification_id($this->classification_id['id'])
			->andDate($this->dateNow())
			->setStatus("presence")->update()->result();
		if($insert_presence){
			return true;
		}
		return false;
	}

	function nationalcode($code = false) {
		$r = false;
		if (strlen($code) == 10) {
			$c = str_split($code);
			$main_place = array();
			$i = 10;
			$p = 0;
			foreach ($c as $n => $value) {
				$main_place[$i] = $value;
				if ($i != 1) {
					$p = $p + ($value * $i);
				}
				$i--;
			}
			$ba = fmod($p, 11);
			if ($ba < 2) {
				if ($main_place[1] == $ba) {
					$r = true;
				}else{
					$r = false;
				}
			}else{
				if ($main_place[1] == (11 - $ba)) {
					$r = true;
				}else{
					$r = false;
				}
			}
		}
		if ($r) {
			return true;
		}else{
			return false;
		}
	} 
}
?>