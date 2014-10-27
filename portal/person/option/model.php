<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class model extends main_model{
	public function makeQuery(){
		return $this->sql()->tablePerson()
				->setName(post::name())
				->setFamily(post::family())
				->setFather(post::father())
				->setBirthday(post::birthday())
				->setGender(post::gender())
				->setNationalcode(post::nationalcode())
				->setCode(post::code())
				->setFrom(post::from())
				->setNationality(post::nationality())
				->setMarriage(post::marriage())
				->setChild(post::child())
				->setType(post::type())
				->setCasecode(post::casecode())
				->setCasecode_old(post::casecode_old())
				->setEducation_id(post::education_id());
				// ->setEn_name(post::en_name())
				// ->setEn_family(post::en_family())
				// ->setEn_father(post::en_father())
				// ->setThird_name(post::third_name())
				// ->setThird_family(post::third_family())
				// ->setThird_father(post::third_father())
				// ->setPasport_date(post::pasport_date());
				// ->setUsers_id($this->uId());
	}
	public function post_add_person() {
		// $sql = $this->makeQuery()
		// 		->insert() 
		// 		->string();
		// $this->commit(function() {
		// 	debug_lib::true("[[insert person successful]]");
		// });
		// $this->rollback(function() {
		// 	debug_lib::fatal("[[insert person failed]]");
		// });
	}

	public function post_edit_person() {
		// print_r(post::birthday());
		// exit();
		$makeQuery = $this->sql()->tablePerson()
				->setName(post::name())
				->setFamily(post::family())
				->setFather(post::father())
				->setBirthday(post::birthday())
				->setGender(post::gender())
				->setNationalcode(post::nationalcode())
				->setCode(post::code())
				// ->setFrom(post::from())
				// ->setNationality(post::nationality())
				->setMarriage(post::marriage())
				->setChild(post::child())
				->setType(post::type())
				->setEducation_id(post::education_id());

		$sql = $makeQuery
			->whereId($this->xuId())
			->update();
			// var_dump($sql->string());
		// exit();
		$this->commit(function() {
			debug_lib::true("[[update person successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update person failed]]");
		});
	}

	public function sql_person_id() {
		if(isset($_SESSION['users_id'])){
			return $this->sql()->tablePerson()->whereUsers_id($_SESSION['users_id'])->limit(1)->select()->assoc("id");
		}else{
			return false;
		}
	}
	public function sql_province_list() {
		return $this->sql()->tableProvince()->select()->allAssoc();
	}

	public function sql_education_list() {
		return $this->sql()->tableEducation()->groupbyGroup()->select()->allAssoc();
	}
}
 ?>