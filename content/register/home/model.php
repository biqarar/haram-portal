<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class model extends main_model {
	
	public function makeQuery() {
		$sqlUsers = $this->sql()->tableUsers()
		->setEmail(post::email());
		$sqlPerson = $this->sql()->tablePerson()
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
		->setEducation_id(post::education_id())
		->setPasport_date(post::pasport_date());
		return array($sqlUsers, $sqlPerson);

	}

	public function post_add_users() {
		// I Agree the regulation
		if(!post::agree()) {
			debug_lib::fatal("[[please agree the regulation]]");
		} 
		
		if(isset($_SESSION['load_captcha']) && $_SESSION['load_captcha']) {
			if(post::captcha() != $_SESSION['CAPTCHA_GNA']){
				debug_lib::fatal("captcha incorrect");
			}
		}

		$this->sql("loginCounter.register", "register");

		list($users, $person) = $this->makeQuery();
		$users->setPassword(md5(post::nationalcode()));
		$sqlUsers = $users->insert();
		$users_id = $sqlUsers->LAST_INSERT_ID();
		$sqlPerson = $person
		->setUsers_id($users_id)->insert();
		$username = 	$this->sql()->tableUsers()->whereId($users_id)->limit(1)->select()->assoc("username");
		
		$sqlBridge = $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("mobile")->setValue(post::mobile())->insert();

		$this->commit(function($username = false) {
			debug_lib::msg("ثبت نام شما با موفقیت انجام شد ، نام کاربری شما  $username  و کلمه عبور شما کد ملی یا شماره گذر نامه شما می باشد.");
			debug_lib::true("ثبت نام شما با موفقیت انجام شد ، نام کاربری شما  $username  و کلمه عبور شما کد ملی یا شماره گذر نامه شما می باشد.");
			// debug_lib::true("[[insert users successful]]");
		}, $username);			
		$this->rollback(function() {
			debug_lib::fatal("[[insert users failed]]");
		});
	}

	public function post_edit_users() {
		list($users, $person) = $this->makeQuery();
		$sqlPerson = $person->whereId($this->uId())->update();
		$sqlUsers = $users->whereId($sqlPerson->assoc('id'))->update();
		$this->commit(function($id = false) {
			debug_lib::true("[[update users successful]]");
		}, $this->uId());
		$this->rollback(function($id = false) {
			debug_lib::fatal("[[update users failed]]");
		}, $this->uId());
	}

	public function sql_province_list() {
		return $this->sql()->tableProvince()->select()->allAssoc();
	}

	public function sql_education_list() {
		return $this->sql()->tableEducation()->groupbyGroup()->select()->allAssoc();
	}
}
?>